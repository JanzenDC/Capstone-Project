<template>
  <SideBar/>
  <q-page class="bg-[#f5f5f5] ">
    <div class="text-[30px] bg-white p-4">
      <div class='justify-between flex'>
        <div class="items-center flex">
          <q-icon
            name="menu"
            v-if="showMenuIcon"
            @click="toggleDrawer"
            class="cursor-pointer"
          />
          <q-icon
            name="menu"
            v-if="!showMenuIcon"
            @click="toggleDrawer"
            class="cursor-pointer max-[1020px]:flex min-[1020px]:hidden"
          />
        <span class="font-bold">Dashboard</span>
        </div>
        <div class='flex items-center'>
          <q-img
            :src="getUserProfileImagePath()"
            alt="Description of the image"
            class="w-12 md:w-12 rounded-full"
          />
          <q-icon :name="modalVisible ? 'keyboard_arrow_up' : 'keyboard_arrow_down'" @click="toggleModal" />
          <div v-show="modalVisible" class="fixed right-3 -top-[160px] overflow-y-auto z-50" @click="toggleModal">
            <div class="flex items-center justify-center min-h-screen">
              <div class="bg-white rounded-lg shadow-xl text-[16px]">
                <div class='bg-[#291B0E] w-full h-[50px] rounded-lg'>
                </div>
                <div class='p-4 px-2 relative '>
                  <q-img
                    :src="getUserProfileImagePath()"
                    alt="Description of the image"
                    class="w-12 md:w-14 rounded-full absolute -top-[30px] left-[64px] "
                  />
                  <div class='mt-4'>
                    <div class='text-center mb-2'>
                      {{ getLimitedFullname(fullname, 25) }}
                    </div>
                    <router-link to="/dashboard/account-settings" class='p-2'>
                      <q-icon name="settings" class="mr-2"/> <span >Account Settings</span>
                    </router-link>
                    <div @click="OpenLogout = true" class='flex items-center cursor-pointer p-2 hover:bg-red-200 hover:text-red-500'>
                      <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
                      <p>Logout</p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class='flex items-center p-4 gap-5'>
      <q-img
        :src="getUserProfileImagePath()"
        alt="Description of the image"
        class="w-12 md:w-[80px] rounded-full"
      />
      <div>
        <p class='text-[16px] font-bold'>Hello, {{ firstname }}</p>
        <p>Here is the quick overview of the system.</p>
      </div>
    </div>
    <div class='flex p-4'>
      <div class='w-2/3'>
        <div class='grid grid-cols-3 gap-6'>
          <div class='p-4 bg-[#109CF1] rounded flex items-center gap-3'>
            <q-icon name='shopping_bag' class='text-white bg-[#967259] text-h3 p-2 rounded'/>
            <div>
              <p class='font-bold text-h5'>1250</p>
              <p>Purchase Order</p>
            </div>
          </div>

          <div class='p-4 bg-[#D8FAE7] rounded flex items-center gap-3'>
            <q-icon name='shopping_bag' class='text-white bg-[#967259] text-h3 p-2 rounded'/>
            <div>
              <p class='font-bold text-h5'>1359</p>
              <p>Total Stocks</p>
            </div>
          </div>
        </div>
      </div>
      <div class='w-1/3'>...</div>

    </div>
  </q-page>
  <q-dialog v-model="OpenLogout">
  <q-card class="w-[500px]">
    <q-card-section class="gap-3 items-center q-pb-none flex">
      <div class="py-1 px-2 border text-[24px]"><q-icon name="logout"/></div>
      <div class="text-h6 font-bold">Logout</div>
      <q-space />
    </q-card-section>

    <q-card-section>

      <p>Are you sure you want to Logout?</p>
    </q-card-section>

    <q-card-actions class="flex justify-center items-center">
      <div class="w-1/2 p-1">
        <q-btn flat label="Cancel" outline v-close-popup class="w-full border"/>
      </div>
      <div class="w-1/2 p-1">
        <q-btn
          @click="logout"
          flat
          label="Logout"
          size="md"
          class="bg-red-600 text-white rounded w-full"
        />
      </div>
    </q-card-actions>
  </q-card>
  </q-dialog>
  </template>

  <script>
  import { useQuasar } from 'quasar';
  import { SessionStorage } from 'quasar';
  import axios from 'axios';
  import SideBar from './Essentials/SideBar.vue';
  export default {
    components: {
      SideBar,
    },
    data() {
      return {
        isAdmin: 0,
        email: '',
        fullname: '',
        firstname: '',
        middlename: '',
        lastname: '',
        userProfileImage: null,
        username: '',
        position: '',
        status: '',
        drawer: false,
        showMenuIcon: false,
        statusCheckTimer: null,
        toggleDrawers: true,
        drawerWidth: 300,
        drawerIcon: 'arrow_back_ios',
        inventoryMenuVisible: false,
        productionVisible: false,
        OpenLogout: false,
        modalVisible: false,
      };
    },
    mounted() {
      this.loadUserData();
      this.statusCheckTimer = setInterval(() => {
        this.checkUserStatus();
      }, 20 * 1000); // 1 second (in milliseconds)
    },
    beforeUnmount() {
      clearInterval(this.statusCheckTimer);
    },
    methods: {
      toggleModal() {
        this.modalVisible = !this.modalVisible;
      },
      toggleProduction(){
        this.productionVisible = !this.productionVisible;
      },
      toggleInventoryMenu() {
        this.inventoryMenuVisible = !this.inventoryMenuVisible;
      },
      toggleDrawer() {
        if (!this.toggleDrawers) {
          this.drawer = true;
          this.drawerWidth = 300;
          this.drawerIcon = 'arrow_forward_ios';
          this.toggleDrawers = true;
        } else {
          this.drawer = true;
          this.drawerWidth = 80;
          this.toggleDrawers = false;
          this.drawerIcon = 'arrow_back_ios_new';
        }
      },
      checkUserStatus() {
          axios.get(`http://localhost/Capstone-Project/backend/api/verification.php?email=${this.email}`)
          .then(response => {
          console.log(response.data);

          const information = response.data.information;
            this.information = {
              id: information.id,
              email: information.email,
              username: information.username,
              pfp: information.pfp,
              firstname: information.firstname,
              middlename: information.middlename,
              lastname: information.lastname,
              gender: information.gender,
              position: information.position,
              mobilenumber: information.mobilenumber,
              birthdate: information.birthdate,
              age: information.age,
              address: information.address,
              otp_code: information.otp_code,
              isOnline: information.isOnline,
              status: information.status,
              password: information.password,
              isAdmin: information.isAdmin,
              suffix: information.suffix,
              civil_status: information.civil_status
            };
            SessionStorage.set('information', JSON.stringify(this.information));

            const latestAdmin = response.data.information.isAdmin;
            const latestStatus = response.data.information.status;

            if (this.status !== latestStatus || (latestAdmin && latestStatus === 0)) {
              this.status = latestStatus;

              if (!latestAdmin  && this.status === 0 ) {
                this.$q.notify({
                  type: 'negative',
                  message: 'Your account is currently inactive. Please contact the administrator.',
                });
                this.$router.push('/');
                sessionStorage.clear();
              }
            }
        }).catch(error => {
              console.error('Error fetching data:', error);
        });
      },
      loadUserData() {
        const userData = SessionStorage.getItem('information');

        if (userData) {
          try {
            const userInformation = JSON.parse(userData);
            this.email = userInformation.email;
            this.username = userInformation.username;
            this.userProfileImage = userInformation.pfp;
            this.firstname = userInformation.firstname;
            this.middlename = userInformation.middlename;
            this.lastname = userInformation.lastname;
            this.position = userInformation.position;
            this.status = userInformation.status;
            this.isAdmin = userInformation.isAdmin;
            this.fullname = this.firstname + " " + this.lastname;
            if (this.position.toLowerCase() === 'owner') {
              this.$router.push('/dashboard/main-dashboard');
            } if (this.position.toLowerCase() === 'production staff') {
              this.$router.push('/dashboard/productionstaff-dashboard');
            } if (this.position.toLowerCase() === 'warehouseman') {
              this.$router.push('/dashboard/warehouseman-dashboard');
            }
            if (this.status === 0 && !this.isAdmin) {
              this.$q.notify({
                type: 'negative',
                message: 'Your account is currently inactive. Please contact the administrator.',
              });
              this.$router.push('/');
              sessionStorage.clear();
            }

          } catch (error) {
            console.log('Error parsing user data:', error);
            // Provide user feedback or navigate to an error page
            this.$q.notify({
              type: 'negative',
              message: 'Error loading user data. Please try again.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }
        } else {
          // Handle the case when user data is not available
          this.$router.push('/');
          sessionStorage.clear();
        }
      },
      getLimitedFullname(fullname, maxLength) {
        if (fullname.length > maxLength) {
          return fullname.substring(0, maxLength) + '...';
        }
        return fullname;
      },
      getUserProfileImagePath() {
        // Ensure userProfileImage is not null before creating the path
        if (this.userProfileImage) {
          return `/pfp/${this.userProfileImage}`;
        } else {
          // Return a default path or handle it as per your requirement
          return '/default_profile.png';
        }
      },
      logout() {
        sessionStorage.clear();
        this.$router.push('/');
      },
    },
  };
  </script>
