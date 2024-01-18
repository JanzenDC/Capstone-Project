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
  <q-page class="bg-[#f5f5f5] p-4">
    <div class="bg-white h-[520px] rounded p-10 overflow-auto">
      <p class="text-[15px]"><q-icon name="arrow_back_ios"/> <span class=" font-bold text-[#9e896a]">Basic Info</span></p>
      <div class="w-[800px] h-[400px] mt-2 border border-[#dfc8c0] rounded p-5 text-[15px]">
        <q-form
          @submit="onSubmit"
        >
          <p class="text-[#9e896a] font-bold">Name</p>
          <div class="grid grid-cols-2 gap-4 mt-3">
              <q-input v-model="name" label="First name" outlined   class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
              <q-input v-model="gender" label="Last name" outlined   class=" rounded" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="">
              <p class="text-[#9e896a] font-bold">Birthday</p>
              <div class="grid grid-cols-3 gap-4 mt-3">
                <q-input
                  v-model="day"
                  label="Day"
                  outlined

                  class="rounded"
                />
                <!-- Year Input -->
                <q-input
                  v-model="year"
                  label="Year"
                  outlined

                  class="rounded"
                />
                <!-- Month Input -->
                <q-select
                  v-model="month"
                  label="Months"
                  outlined
                  class="rounded"
                  :options="monthsOptions"
                />
              </div>
            </div>
            <div class="">
              <p class="text-[#9e896a] font-bold">Position</p>
              <q-input v-model="position" label="Position" outlined  disable class=" rounded mt-3" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            </div>
          </div>
          <div>
          <p class="text-[#9e896a] font-bold">Gender</p>

          <!-- q-radio for male -->
          <q-radio
            v-model="gender"
            val="male"
            label="Male"
            color="primary"
          />

          <!-- q-radio for female -->
          <q-radio
            v-model="gender"
            val="female"
            label="Female"
            color="primary"
          />

          <!-- q-radio for rather not to say -->
          <q-radio
            v-model="gender"
            val="notToSay"
            label="Rather Not to Say"
            color="primary"
          />
        </div>
        </q-form>
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
      name: '',
      gender: '',
      day: '',
      year: '',
      position: '',
      mobilenumber: '',
      password: '',
      drawerVisible: true,
      months: '',
      month: '',  // Newly added property for v-model binding
      monthsOptions: [
        { label: 'January', value: '01' },
        { label: 'February', value: '02' },
        { label: 'March', value: '03' },
        { label: 'April', value: '04' },
        { label: 'May', value: '05' },
        { label: 'June', value: '06' },
        { label: 'July', value: '07' },
        { label: 'August', value: '08' },
        { label: 'September', value: '09' },
        { label: 'October', value: '10' },
        { label: 'November', value: '11' },
        { label: 'December', value: '12' },
      ],
    };
  },

  mounted() {
    this.loadUserData();
  },
  methods: {
    loadUserData() {
      const userData = SessionStorage.getItem('information');
      console.log("Response Data:", userData);
      if (userData) {
        try {
          const userInformation = JSON.parse(userData);
          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
          this.name = userInformation.fullname;
          this.gender = (userInformation.gender || '').toLowerCase();

          this.position = userInformation.position;
          this.mobilenumber = userInformation.mobilenumber;
          this.password = userInformation.password;

          if (userInformation.birthdate) {
            const birthdateParts = userInformation.birthdate.split('-');
            if (birthdateParts.length === 3) {
              this.day = birthdateParts[2];
              this.month = this.getMonthName(birthdateParts[1]);
              this.year = birthdateParts[0];
            }
          }
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
    getMonthName(monthNumber) {
      // Add logic to get the month name based on the month number
      const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
      ];

      return monthNames[parseInt(monthNumber, 10) - 1] || '';
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
