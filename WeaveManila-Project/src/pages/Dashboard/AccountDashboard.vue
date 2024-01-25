<template>
<q-header elevated class="bg-white w-full text-black h-[100px]  md:flex md:justify-between border-2">
  <div class="md:w-[400px] p-4 md:flex min-[390px]:hidden">
      <div>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        <q-img
          src="../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[60px] md:w-[60px] "
        />
      </div>
      <div class="w-[250px]">
        <p class="text-[20px] text-[#8F8073] font-bold ">WEAVEMANILA INC.</p>
        <p class="text-[12px] text-[#9e896a]">Production Monitoring & Inventory Management System</p>
      </div>
  </div>
  <div class="flex items-center p-4 gap-2 min-[390px]:justify-between">
    <q-btn flat @click="drawer = !drawer" round dense icon="menu" class="md:hidden"/>
    <div class="flex items-center p-4 gap-2">
    <q-icon name="notifications" class="text-[21px]"/>
    <div>
        <q-img
          :src="getUserProfileImagePath()"
          alt="Description of the image"
          class="w-12 md:w-12 rounded-full border-black border"
        />
        </div>
        <div>
          {{ firstname }}
        </div>
        <q-icon
          :name="arrowDirection ? 'arrow_drop_up' : 'arrow_drop_down'"
          class="text-[25px] cursor-pointer"
          @click="toggleModal"
        />
      </div>
    <div v-if="showModal" class="fixed right-5 top-[110px] transform bg-white p-3 border border-gray-300 z-50 rounded-md drop-shadow-lg w-[308px] h-[200px]">
      <div class="flex justify-center">
        <div>
          <div class="flex justify-center mt-3 ">
            <q-img
              :src="getUserProfileImagePath()"
              alt="Description of the image"
              class="w-[80px] rounded-full border-black border"
            />
          </div>
          <div class="font-bold">{{ firstname }} {{ lastname }}</div>
          <div class="text-center">{{ position }}</div>
        </div>
      </div>
      <router-link to="/dashboard/account-settings">
        <p class="flex justify-between text-[16px]">
          Account Settings <q-icon name="manage_accounts" class="mr-2 text-[16px]"/>
        </p>
      </router-link>
      <router-link @click="logout" to="/">
        <p class="flex justify-between text-[16px]">
          Logout <q-icon name="logout" class="mr-2 text-[16px]"/>
        </p>
      </router-link>
    </div>
  </div>
</q-header>
<q-drawer
  show-if-above
  v-model="drawer"
  side="left"
  bordered
  :width="250">
      <ul class="p-4">
        <li class="font-bold">Overview</li>
          <li class="py-[17px] px-[20px]">
            <div class="flex items-center">
              <router-link to="/dashboard/main-dashboard">
              <q-icon name="dashboard" class="mr-2"/> Dashboard
              </router-link>
            </div>
          </li>
          <!-- Process Section -->
          <li class="font-bold">Process</li>
          <li class="py-[17px] px-[20px]">
            <div class="flex items-center gap-2">
              <q-icon name="inventory"/> Inventory
            </div>
          </li>
          <li class="py-[17px] px-[20px] ">
            <div class="flex items-center gap-2">
              <q-icon name=""/> Product Monitoring
            </div>
          </li>
          <li class="py-[17px] px-[20px]">
            <div class="flex items-center">
              <q-icon name="description" class="mr-2"/> Production Cost Report
            </div>
          </li>
          <!-- Settings Section -->
          <li class="font-bold">Settings</li>
          <li class="py-[17px] px-[20px]">
            <div class="flex items-center">
              <router-link to="/dashboard/auditlogs-section">
                <q-icon name="" class="mr-2"/> Audit Logs
              </router-link>
            </div>
          </li>
          <li class="py-[17px] px-[20px]">
            <div class="flex items-center">
              <q-icon name="group" class="mr-2"/> User Management
            </div>
          </li>
      </ul>
  </q-drawer>
  <q-page class="bg-[#f5f5f5] p-4">
    <div class="bg-white h-[520px] rounded p-4 px-7 overflow-y-auto overflow-x-hidden">
      <h1 class="text-[25px] font-bold">Account Settings</h1>
      <div class="w-full md:flex md:justify-center">
        <div>

          <!-- User Area -->
          <div class="p-4 md:w-[600px] h-[150px] border border-[#ddb7ab] rounded-[15px] drop-shadow-md flex md:justify-between
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
                    <router-link to="/dashboard/account-profilepic">
                      <div class="rounded-full py-2 px-3 bg-[#ddb7ab] md:hidden">
                        <q-icon name="photo_camera"/>
                      </div>
                    </router-link>
                  </div>
                </div>

              </div>
              <div class="text-center">
                <p class="font-bold text-[16px]">{{ firstname }} {{ lastname }}</p>
                {{ position }}
              </div>
            </div>
              <div class="w-[84px] flex items-center justify-center min-[390px]:hidden md:flex ">
                <router-link to="/dashboard/account-profilepic" class="text-center w-full border border-[#9e896a] rounded-full ">
                  <span class=" p-1   text-[#9e896a]"><q-icon name="edit"/> Edit</span>
                </router-link>
              </div>
          </div>


          <!-- Personal Information -->
          <div class="mt-3 md:w-[600px] p-5 border border-[#ddb7ab] rounded-[15px] drop-shadow-md">
            <div class="flex justify-between -mt-8">
              <h1 class="md:text-[19px] font-bold">Personal Information</h1>
              <div class="w-[84px] flex items-center justify-center ">
                <router-link to="/dashboard/account-basicinfo" class="text-center w-full border border-[#9e896a] rounded-full">
                  <span class=" p-1   text-[#9e896a]"><q-icon name="edit"/> Edit</span>
                </router-link>
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
          <!-- Contact Information -->
          <div class="mt-3 md:w-[600px] p-5 border border-[#ddb7ab] rounded-[15px] drop-shadow-md">
            <div class="flex justify-between -mt-8">
              <h1 class="md:text-[19px] font-bold">Contact Information</h1>
              <div class="w-[84px] flex items-center justify-center ">
                <router-link to="/dashboard/account-contactinfo" class="text-center w-full border border-[#9e896a] rounded-full">
                  <span class=" p-1   text-[#9e896a]"><q-icon name="edit"/> Edit</span>
                </router-link>
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
          <!-- Password Information -->
          <div class="mt-3 md:w-[600px] p-5 border border-[#ddb7ab] rounded-[15px] drop-shadow-md">
            <div class="flex justify-between -mt-8">
              <h1 class="md:text-[19px] font-bold">Security</h1>
              <div class="w-[84px] flex items-center justify-center ">
                <router-link to="/dashboard/account-changepass" class="text-center w-full border border-[#9e896a] rounded-full">
                  <span class=" p-1   text-[#9e896a]"><q-icon name="edit"/> Edit</span>
                </router-link>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-10 -mt-4">
              <div>
                <p>Current Password</p> {{ password }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';

export default {
  setup() {
    const $q = useQuasar();
  },
  data() {
    return {
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
      arrowDirection: false,
      showModal: false,
      drawer: false,
    };
  },
  mounted() {
    this.loadUserData();
  },

  methods: {
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
