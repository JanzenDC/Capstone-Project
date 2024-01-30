<template>
<q-drawer
show-if-above
v-model="drawer"
side="left"
bordered
:width="drawerWidth">
  <ul class="p-2 flex flex-col h-full static" v-if="drawerWidth !== 80">

    <div @click="toggleDrawer" class="absolute -right-4 top-4 text-[18px] bg-white drop-shadow-lg rounded-full px-2 py-1 text-center cursor-pointer">
      <q-icon :name="drawerIcon"/>
    </div>
    <div class="flex">
      <div class="w-1/4 items-center flex justify-center" >
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[50px] md:w-[60px]"
        />
      </div>
      <div class=" items-center flex justify-center" v-if="drawerWidth <= 80">
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[150px] md:w-[60px]"
        />
      </div>
        <div class="text-[#281c0f] w-3/4" v-if="drawerWidth !== 80">
          <span class=" font-bold text-[20px]">WEAVEMANILA INC.</span><br>
          <span class="text-[#281c0f] text-[12px]">Production Monitoring & Inventory Management System</span>

        </div>
    </div>



    <li class="font-bold">Overview</li>
      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center">
          <router-link to="/dashboard/main-dashboard">
          <q-icon name="dashboard" class="mr-2" /> <span >Dashboard</span>
          </router-link>
        </div>
      </li>
      <!-- Process Section -->
      <li class="font-bold" >Process</li>
      <li class="py-[10px] px-[20px]" @click="toggleInventoryMenu">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/> <span >Inventory</span></div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="inventoryMenuVisible">
          <li class="py-[2px] px-[40px] mt-3">Purchase Order</li>
          <li class="px-[40px] mt-3">Supplier List</li>
        </ul>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2">
          <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <q-icon name="description" class="mr-2"/><span >Production Cost Report</span>
        </div>
      </li>
      <!-- Settings Section -->
      <li class="font-bold" >Settings</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/auditlogs-section">
            <i class="bi bi-activity mr-2"></i> <span >Audit Logs</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/usermanagement-section">
            <q-icon name="group" class="mr-2"/> <span >User Management</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/account-settings">
            <q-icon name="manage_accounts" class="mr-2"/> <span >Account Settings</span>
          </router-link>
        </div>
      </li>
      <li class="mt-auto py-[10px]">
        <div class="flex justify-between text-center" >
          <div class="flex items-center" >
            <q-img
              :src="getUserProfileImagePath()"
              alt="Description of the image"
              class="w-12 md:w-12 rounded-full"
            />
            <div class="ml-2 overflow-hidden">
              <div class="whitespace-nowrap overflow-hidden text-overflow-ellipsis font-bold">
                {{ getLimitedFullname(fullnames, 25) }}
              </div>
              <div class="text-center">
                {{ position }}
              </div>
            </div>
          </div>
          <div class="flex items-center ">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
          </div>
        </div>
      </li>
  </ul>

  <ul class="p-2 flex flex-col h-full static" v-if="drawerWidth <= 80">
    <div @click="toggleDrawer" class="absolute -right-4 top-4 text-[18px] bg-white drop-shadow-lg rounded-full px-2 py-1 text-center cursor-pointer">
      <q-icon :name="drawerIcon"/>
    </div>
    <div class="flex">
      <div class=" items-center flex justify-center" v-if="drawerWidth <= 80">
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[150px] md:w-[60px]"
        />
      </div>
    </div>


      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="dashboard" />
        </div>
      </li>
      <!-- Process Section -->

      <li class="py-[10px] px-[20px]" @click="toggleDrawer">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/></div>
        </div>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2" @click="toggleDrawer">
          <i class="bi bi-box-seam"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="description" />
        </div>
      </li>
      <!-- Settings Section -->
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <i class="bi bi-activity"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="group" class="mr-2"/>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="manage_accounts"/>
        </div>
      </li>
      <li class="mt-auto py-[10px]">
          <div class="flex justify-center ">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
          </div>
      </li>

  </ul>
</q-drawer>
<q-page class="bg-[#f5f5f5] p-4">
  <div class="h-[620px] rounded p-4 px-7">
    <div class="">
      <div class="text-[30px] flex items-center min-[360px]:gap-5">
        <q-icon
          name="menu"
          @click="toggleDrawer"
          class="cursor-pointer text-[20px] min-[360px]:flex md:hidden "
        />
          <span class="font-bold">Account Settings</span>
      </div>
      <div class="text-[16px]">Setup you account, edit profile details & change password</div>

    </div>
    <div class="w-full md:flex md:justify-center mt-3 overflow-y-auto overflow-x-hidden h-[500px]">
    <div>
        <!-- User Area -->
        <div class="p-4 md:w-[600px] h-[130px] border border-[#ddb7ab] rounded-[15px] drop-shadow-md flex md:justify-between
        min-[390px]:justify-center">
          <div class="md:flex items-center gap-2">
            <div>
              <div  class="relative flex justify-center items-center">
                <q-img
                  :src="getUserProfileImagePath()"
                  alt="Description of the image"
                  class="w-[100px] rounded-full min-[390px]:w-[80px] "
                />
                <div class="absolute right-12 bottom-0">
                    <div class="rounded-full py-2 px-3 bg-[#ddb7ab] md:hidden" @click="editProfile = true">
                      <q-icon name="photo_camera"/>
                    </div>
                </div>
              </div>

            </div>
            <div class="text-center">
              <p class="font-bold text-[16px]">{{ firstname }} {{ lastname }}</p>
              {{ position }}
            </div>
          </div>
            <div class="w-[84px] flex items-center justify-center min-[390px]:hidden md:flex ">
              <q-btn @click="editProfile = true" unelevated rounded outline size="sm" class="rounded-full w-full text-[#9e896a] text-[12px]">
                <q-icon name="edit"/> Edit
              </q-btn>
            </div>
        </div>
        <q-dialog v-model="editProfile">
          <q-card>
            <q-card-section class="row items-center q-pb-none">
              <div class="text-h6">Change Avatar</div>
              <q-space />
              <q-btn icon="close" flat round dense v-close-popup />

            </q-card-section>
            <q-separator />
            <q-card-section>
              <UserProfile />
            </q-card-section>
          </q-card>
        </q-dialog>

        <!-- Personal Information -->
        <div class="mt-3 md:w-[600px] p-5 border border-[#ddb7ab] rounded-[15px] drop-shadow-md">
          <div class="flex justify-between -mt-8">
            <h1 class="md:text-[19px] font-bold">Personal Information</h1>
            <div class="w-[84px] flex items-center justify-center ">
              <q-btn @click="editBasicInfo = true" unelevated rounded outline size="sm" class="rounded-full w-full text-[#9e896a] text-[12px]">
                <q-icon name="edit"/> Edit
              </q-btn>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-10 -mt-4">
            <div>
              <p>First Name:</p> {{ firstname }}
            </div>
            <div>
              <p>Last Name:</p> {{ lastname }}
            </div>
            <div>
              <p>Birthday:</p> {{ birthdate }}
            </div>
            <div>
              <p>Gender:</p> {{ gender }}
            </div>
            <div>
              <p>Address:</p> {{ address }}
            </div>
            <div>
              <p>Position:</p> {{ position }}
            </div>
          </div>
        </div>
        <q-dialog v-model="editBasicInfo">
          <q-card>
            <q-card-section class="row items-center q-pb-none">
              <div class="text-h6">Personal Information</div>
              <q-space />
              <q-btn icon="close" flat round dense v-close-popup />

            </q-card-section>
            <q-separator />
            <q-card-section>
              <BasicInfo />
            </q-card-section>
          </q-card>
        </q-dialog>

        <!-- Contact Information -->
        <div class="mt-3 md:w-[600px] p-5 border border-[#ddb7ab] rounded-[15px] drop-shadow-md">
          <div class="flex justify-between -mt-8">
            <h1 class="md:text-[19px] font-bold">Contact Information</h1>
            <div class="w-[84px] flex items-center justify-center ">
              <q-btn @click="editContactInfo = true" unelevated rounded outline size="sm" class="rounded-full w-full text-[#9e896a] text-[12px]">
                <q-icon name="edit"/> Edit
              </q-btn>
            </div>
          </div>
          <div class="md:grid md:grid-cols-2 md:gap-10 -mt-4">
            <div>
              <p>Email:</p> {{ email }}
            </div>
            <div class="min-[390px]:mt-3">
              <p>Mobile Number:</p> {{ mobilenumber }}
            </div>
          </div>
        </div>
        <q-dialog v-model="editContactInfo" >
          <q-card class="w-[500px]">
            <q-card-section class="row items-center q-pb-none">
              <div class="text-h6">Contact Information</div>
              <q-space />
              <q-btn icon="close" flat round dense v-close-popup />

            </q-card-section>
            <q-separator />
            <q-card-section>
              <ContactInfo />
            </q-card-section>
          </q-card>
        </q-dialog>

        <!-- Password Information -->
        <div class="mt-3 md:w-[600px] p-5 border border-[#ddb7ab] rounded-[15px] drop-shadow-md">
          <div class="flex justify-between -mt-8">
            <h1 class="md:text-[19px] font-bold">Security</h1>
            <div class="w-[84px] flex items-center justify-center ">
              <q-btn @click="editPasswordInfo = true" unelevated rounded outline size="sm" class="rounded-full w-full text-[#9e896a] text-[12px]">
                <q-icon name="edit"/> Edit
              </q-btn>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-10 -mt-4">
            <div>
              <p>Current Password</p> {{ password }}
            </div>
          </div>
        </div>
        <q-dialog v-model="editPasswordInfo" >
          <q-card class="w-[800px]">
            <q-card-section class="row items-center q-pb-none">
              <div class="text-h6">Security</div>
              <q-space />
              <q-btn icon="close" flat round dense v-close-popup />

            </q-card-section>
            <q-separator />
            <q-card-section>
              <PasswordInfo />
            </q-card-section>
          </q-card>
        </q-dialog>

      </div>
    </div>
  </div>
</q-page>
</template>

<script>
// import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import UserProfile from './AccountUserprofile.vue';
import BasicInfo from './AccountBasicinfo.vue';
import ContactInfo from './AccountContactInfo.vue';
import PasswordInfo from './AccountSecurity.vue';

export default {
  components: {
    UserProfile,
    BasicInfo,
    ContactInfo,
    PasswordInfo,
  },
  data() {
    return {
      id: '',
      email: '',
      userProfileImage: null,
      username: '',
      firstname: '',
      middlename: '',
      lastname: '',
      gender: '',
      birthdate: '',
      address: '',
      position: '',
      mobilenumber: '',
      password: '',
      status: '',
      arrowDirection: false,
      showModal: false,
      fullnames: '',
      toggleDrawers: true,
      drawer: false,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      statusCheckTimer: null,
      editProfile: false,
      editBasicInfo: false,
      editContactInfo: false,
      editPasswordInfo:false,
    };
  },
  mounted() {
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
    this.checkUserStatus();
    }, 1 * 1000); // 5 minutes (in milliseconds)
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },

  methods: {
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
        const latestStatus = response.data.information.status;
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
          };
          SessionStorage.set('information', JSON.stringify(this.information));
        if (this.status !== latestStatus) {
          this.status = latestStatus;

          if (this.status === 0) {
            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
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
          this.gender = userInformation.gender;
          this.birthdate = userInformation.birthdate;
          this.position = userInformation.position;
          this.mobilenumber = userInformation.mobilenumber;
          this.password = userInformation.password ? '*'.repeat(Math.min(8, userInformation.password.length)) : '';
          this.address = userInformation.address;
          this.status = userInformation.status;
          this.id = userInformation.id;
          this.fullnames = this.firstname + " " + this.lastname;
          if(this.status == 0)
          {
            this.$q.notify({
            type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
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
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
    },
    toggleModal() {
      this.arrowDirection = !this.arrowDirection;
      this.showModal = !this.showModal;
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
