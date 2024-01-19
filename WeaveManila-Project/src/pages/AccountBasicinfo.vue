<template>
<q-header elevated class="bg-white w-full text-black h-[100px]  md:flex md:justify-between border-2">
  <div class="md:w-[400px] p-4 md:flex min-[320px]:hidden">
      <div>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        <q-img
          src="../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[60px] md:w-[60px] "
        />
      </div>
      <div class="w-[250px]">
        <p class="text-[20px] text-[#8F8073] font-bold ">WEAVEMANILA INC.</p>
        <p class="text-[12px] text-[#9e896a]">Production Monitoring & Inventory Management System</p>
      </div>
  </div>
  <div class="flex items-center p-4 gap-2 min-[320px]:justify-between">
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
          name="arrow_drop_down"
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
          <div class="font-bold">{{ fullname }}</div>
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
  <q-drawer show-if-above v-model="drawer" side="left" bordered>
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
    </ul>
  </q-drawer>
  <q-page class="bg-[#f5f5f5] p-4">
    <div class="bg-white h-[520px] rounded p-10 overflow-auto">

<!-- Modal -->
<div class="modal fixed w-full h-full top-0 left-0 flex items-center  z-50  justify-center" v-show="showSuccessModal">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" @click="closeModal"></div>
    <div class="modal-container bg-white w-[400px] h-[230px] md:max-w-md mx-auto rounded shadow-lg  z-50  overflow-y-auto">
      <div class="modal-content py-4 text-left px-6">
        <div class="modal-header flex text-right items-end justify-end">
          <slot name="header">
            <q-icon name="close" class="text-[20px]" @click="closeModal"/>
          </slot>
        </div>
        <div class="modal-body flex justify-center">
          <slot name="body" class="flex">
            <q-icon name="task_alt" class="text-[72px] text-[#9E896A]" />
            <div class="w-full text-center">
              <p class="text-[20px] font-bold">Personal Information Updated!</p>
            </div>
            <div class="w-full text-center">
              <p class="text-[14px]">Your personal information has been changed successfully.</p>
            </div>
          </slot>
        </div>
      </div>
    </div>
  </div>

      <router-link to="/dashboard/account-settings">
        <p class="text-[15px]"><q-icon name="arrow_back_ios"/> <span class=" font-bold text-[#9e896a]">Basic Info</span></p>
      </router-link>
      <div class="w-[800px] h-[510px] mt-2 border border-[#dfc8c0] rounded p-5 text-[15px]">
        <q-form
          @submit="onSubmit"
        >
          <p class="text-[#9e896a] font-bold">Name</p>
          <div class="grid grid-cols-2 gap-4 mt-3">
              <q-input v-model="firstname" label="First name" outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
              <q-input v-model="lastname" label="Last name" outlined dense  class=" rounded" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
          </div>
          <div class="w-[370px]">
            <div class="">
              <p class="text-[#9e896a] font-bold">Birthday</p>
              <div class="grid grid-cols-3 gap-4 mt-3">
                <q-input
                  v-model="day"
                  label="Day"
                  outlined
                  dense
                  class="rounded"
                  :rules="[validateDay]"
                />
                <!-- Year Input -->
                <q-input
                  v-model="year"
                  label="Year"
                  outlined
                  dense
                  class="rounded"
                  :rules="[validateYear]"
                />
                <!-- Month Input -->
                <q-select
                  v-model="month"
                  label="Months"
                  outlined
                  dense
                  class="rounded"
                  :options="monthsOptions"
                  @change="[validateMonth]"
                />
              </div>
            </div>
            <div class="">
              <p class="text-[#9e896a] font-bold">Position</p>
              <q-input v-model="position" dense label="Position" outlined  disable class=" rounded mt-3" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            </div>
          </div>
          <div class="w-40">
            <p class="text-[#9e896a] font-bold">Gender</p>
            <q-radio
              v-model="gender"
              val="Male"
              label="Male"
              color="primary"
            />
            <q-radio
              v-model="gender"
              val="Female"
              label="Female"
              color="primary"
            />
            <q-radio
              v-model="gender"
              val="Rather Not to Say"
              label="Rather Not to Say"
              color="primary"
            />
          </div>
            <div class="flex justify-end w-full gap-2">
              <router-link to="/dashboard/account-settings" class="bg-white rounded-full text-center p-2 text-[#9e896a] w-[74px] border-2 border-[#9e896a]">
                Cancel
              </router-link>
              <q-btn label="Save" type="submit" class="bg-[#9e896a] rounded-full  text-white"/>
            </div>
        </q-form>
      </div>
    </div>
  </q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';

export default {
  setup() {
    const $q = useQuasar();
  },
  data() {
    return {
      responseInformation: '',
      responseStatus: '',
      email: '',
      userProfileImage: null,
      username: '',
      firstname: '',
      middlename: '',
      lastname: '',
      gender: '',
      day: '',
      year: '',
      position: '',
      mobilenumber: '',
      password: '',
      showModal: false,
      showSuccessModal: false,
      drawer: true,
      month: '',  // Newly added property for v-model binding
      monthsOptions: [
      'January', 'February', 'March', 'April',
      'May', 'June', 'July', 'August',
      'September', 'October', 'November', 'December'
      ],
    };
  },

  mounted() {
    this.loadUserData();
  },
  methods: {
    loadUserData() {
      const userData = SessionStorage.getItem('information');
      console.log(userData);
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

          this.position = userInformation.position;
          this.mobilenumber = userInformation.mobilenumber;
          this.password = userInformation.password;

          if (userInformation.birthdate) {
            const birthdateParts = userInformation.birthdate.split('-');
            if (birthdateParts.length === 3) {
              this.day = birthdateParts[2];
              this.year = birthdateParts[0];
              const monthNumber = parseInt(birthdateParts[1], 10);
              this.month = this.getMonthName(monthNumber);
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
      const months = [
        'January', 'February', 'March', 'April',
        'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'
      ];
      return months[monthNumber - 1] || null;
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
    toggleModal() {
      this.showModal = !this.showModal;
    },
    validateDay(value) {
      if (isNaN(value) || value < 1 || value > 31) {
        return 'Invalid day!';
      }
      return true;
    },
    validateYear(value) {

      if (isNaN(value) || value < 1900 || value > 2100) {
        return 'Invalid year!';
      }
      return true;
    },
    validateMonth(value) {

      if (!value) {
        return 'Month is required!';
      }
      return true;
    },
    onSubmit() {
      this.showSuccessModal = true;
      const formData = {
        Firstname: this.firstname,
        Lastname: this.lastname,
        Day: this.day,
        Month: this.month,
        Year: this.year,
        Gender: this.gender,
      };
      axios.put(`http://localhost/Capstone-Project/backend/api/Account_Settings/basicinfo.php/${this.email}`, formData)
      .then((response) =>{
        this.responseStatus = response.data.status;
        this.responseInformation = response.data.information;
        console.log(this.responseInformation);
        if (this.responseStatus === "success") {
            const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
            existingInformation.firstname = this.responseInformation.firstname;
            existingInformation.lastname = this.responseInformation.lastname;
            existingInformation.birthdate = this.responseInformation.birthdate;
            existingInformation.gender = this.responseInformation.gender;
            SessionStorage.set('information', JSON.stringify(existingInformation));
            this.$router.push('/dashboard/account-basicinfo');
        }
      }).catch(error => {
        console.error('Error submitting form:', error);
      });
    },
    closeModal() {
      this.showSuccessModal = false;
    },
    logout() {
      sessionStorage.clear();
      this.$router.push('/');
    },
  },
};
</script>
