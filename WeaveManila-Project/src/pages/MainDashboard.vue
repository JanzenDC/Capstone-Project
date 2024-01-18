<template>
  <q-header elevated class="bg-white w-full text-black h-[100px] flex justify-between border-2">
      <div class="w-[400px] p-4 flex">
        <div>
          <q-img
            src="../assets/favicon-128x128.png"
            alt="Description of the image"
            class="w-[60px] md:w-[60px]"
          />
        </div>
        <div class="w-[250px]">
          <p class="text-[20px] text-[#8F8073] font-bold">WEAVEMANILA INC.</p>
          <p class="text-[12px] text-[#9e896a]">Production Monitoring & Inventory Management System</p>
        </div>
      </div>
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
          {{ username }}
        </div>
        <q-icon name="arrow_drop_down" class="text-[25px]"/>
      </div>
  </q-header>
  <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
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
            <q-icon name="" class="mr-2"/> Audit Logs
          </div>
        </li>
        <li class="py-[17px] px-[20px]">
          <div class="flex items-center">
            <q-icon name="group" class="mr-2"/> User Management
          </div>
        </li>
        <li class="py-[17px] px-[20px]">
          <div class="flex items-center">
            <router-link to="/dashboard/account-settings">
              <q-icon name="manage_accounts" class="mr-2"/> Account
            </router-link>

          </div>
        </li>
        <li class="py-[17px] px-[20px]">
          <div class="flex items-center">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="mr-2"/> Logout
            </router-link>
          </div>
        </li>
    </ul>
  </q-drawer>
  <!-- <q-page class="bg-[#f5f5f5] p-4">
    <div class="bg-white h-[520px] rounded p-10">
      <div class="text-center text-[#8F8073] text-[40px] font-bold">
        ACCOUNT INFO
      </div>
    </div>
  </q-page> -->
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
      drawerVisible: true,
    };
  },
  mounted() {
    this.loadUserData();
  },
  methods: {
    loadUserData() {
      const userData = SessionStorage.getItem('information');
      console.log('Response Data:', userData);
      if (userData) {
        try {
          const userInformation = JSON.parse(userData);
          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;

        } catch (error) {
          console.log('Error parsing user data:', error);
          // Provide user feedback or navigate to an error page
          this.$q.notify({
            type: 'negative',
            message: 'Error loading user data. Please try again.',
          });
          this.$router.push('/');
        }
      } else {
        // Handle the case when user data is not available
        this.$router.push('/');
      }
    },
    getUserProfileImagePath() {
      // Ensure userProfileImage is not null before creating the path
      if (this.userProfileImage) {
        return `/pfp/${this.userProfileImage}.png`;
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

