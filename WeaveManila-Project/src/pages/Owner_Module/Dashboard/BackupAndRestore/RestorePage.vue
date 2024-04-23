<template>
<SideBar />
<q-page class="bg-[#f5f5f5] ">
  <div class="flex justify-between items-center p-2 bg-white">
    <div class="text-[30px] bg-white p-4">
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
        <div>
          <span class="font-bold">Data Backup and Restore</span>
          <div class="text-[16px]">Efficiently safeguard and recover your data for seamless continuity and security.</div>
        </div>
      </div>
    </div>
    <div class='flex items-center'>
      <q-img
        :src="getUserProfileImagePath()"
        alt="Description of the image"
        class="w-12 md:w-12 rounded-full"
      />
      <q-icon :name="modalVisible ? 'keyboard_arrow_up' : 'keyboard_arrow_down'" size='md' @click="toggleModals" />
      <div v-show="modalVisible" class="fixed right-3 -top-[130px] overflow-y-auto z-50" @click="toggleModals">
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
                <div @click="OpenLogout = true" class='flex items-center p-2 hover:bg-red-200 hover:text-red-500'>
                  <q-icon name="logout" class="text-[16px] font-bold mr-3"/>
                  <p>Logout</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>    
  </div>

  <div class="p-4">
      <div class="flex mt-3">
        <router-link to="/dashboard/backup-section">
          <div class="flex  w-[155px] text-[#b8b8b8] border-l-2 border-t-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="backup"/>
            <p>Backup Data</p>
          </div>
        </router-link>
        <router-link to="/dashboard/restore-section">
          <div class="flex w-[155px] bg-white h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="restore"/>
            <p>Restore Data</p>
          </div>
        </router-link>
      </div>
      <div class="bg-white px-4 py-3">
        <p>Please upload the SQL file with .sql extension to restore the backup data.</p>

        <div class="mt-10 flex gap-4">
          <q-input v-model="selectedFileName" label="Please Choose a File" disable class="w-[200px]" dense outlined/>
          <input
            ref="fileInput"
            type="file"
            id="sql_file"
            class="hidden"
            @change="handleFileUpload"
          />
          <q-btn
            label="Choose a File (.sql)"
            class="bg-[#291B0E] text-white"
            @click="triggerFileInput"
          />
          <q-btn
            v-if="selectedFileName"
            label="Restore Now"
            class="bg-[#17ab00] text-white"
            @click="RestoreSQL"
          />
        </div>
      </div>

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
import SideBar from '../Essentials/SideBar.vue';

export default {
  components: {
    SideBar,
  },
  data() {
    return {
      modalVisible: false,
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
      // New Data
      selectedFileName: '',
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
    toggleModals() {
      this.modalVisible = !this.modalVisible;
    },
    handleFileUpload(event) {
    const file = event.target.files[0];
    if (file) {
      if (file.name.endsWith('.sql')) {
        // Set the selected file name to display in the input
        this.selectedFileName = file.name;
        // You can add further processing here such as sending the file to the server for restoration
        console.log('File uploaded successfully.');
      } else {
        this.$q.notify({
          color: 'negative',
          message: 'Please choose a file with .sql extension.',
        });
      }
    } else {
      this.$q.notify({
        color: 'negative',
        message: 'Please choose a file.',
      });
    }
  },
  triggerFileInput() {
    this.$refs.fileInput.click();
  },
  RestoreSQL() {
    if (!this.selectedFileName) {
      this.$q.notify({
        color: 'negative',
        message: 'Please select a file to restore.',
      });
      return;
    }

    // Show loading indicator
    this.$q.loading.show({
      message: 'Uploading SQL file. This may take a while...', // Updated message
      boxClass: 'bg-grey-2 text-grey-9',
      spinnerColor: 'primary'
    });

    const formData = new FormData();
    formData.append('sql_file', this.$refs.fileInput.files[0]);

    axios.post('http://localhost/Capstone-Project/backend/api/BackupAndRestore/restore.php/', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    .then(response => {
      console.log(response.data);
      const Status = response.data.status;
      const Message = response.data.message;

      // Schedule success notification after 30 seconds
      setTimeout(() => {
        if (Status === "success") {
          this.$q.notify({
            color: 'positive',
            message: 'SQL data restored successfully.',
          });
          this.selectedFileName = '';
        }
      }, 30000); // 30 seconds

      // Show failure notification immediately without delay
      if (Status === "fail") {
        this.$q.notify({
          color: 'negative',
          message: `${Message} Please try again.`,
        });
      }
    })
    .catch(error => {
      // Handle errors
      console.error('Error restoring SQL:', error);
      // Show error message
      this.$q.notify({
        color: 'negative',
        message: 'An error occurred while restoring SQL data.',
      });
    })
    .finally(() => {
      // Hide loading indicator after 30 seconds
      setTimeout(() => {
        this.$q.loading.hide();
      }, 30000); // 30 seconds
    });
  },











    // Old Data
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
          };
          SessionStorage.set('information', JSON.stringify(this.information));

          const latestAdmin = response.data.information.isAdmin;
          const latestStatus = response.data.information.status;

          if (this.status !== latestStatus || (latestAdmin && latestStatus === 0)) {
            this.status = latestStatus;

            if (this.status === 0 && !latestAdmin) {
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

            this.$router.push('/dashboard/restore-section');
          } else {

            this.$q.notify({
              type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
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

