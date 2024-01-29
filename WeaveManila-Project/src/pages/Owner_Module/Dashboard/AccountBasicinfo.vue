<template>
<q-drawer
show-if-above
v-model="drawer"
side="left"
bordered
:width="300">
  <ul class="p-2 flex flex-col h-full static">
    <div @click="toggleDrawer" class="absolute -right-4 top-4 text-[18px] bg-white drop-shadow-lg rounded-full px-2 py-1 text-center cursor-pointer">
      <q-icon name="arrow_back_ios_new"/>
    </div>
    <div class="flex">
      <div class="w-1/4 items-center flex justify-center">
        <q-img
          src="../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[50px] md:w-[60px]"
        />
      </div>
        <div class="text-[#281c0f] w-3/4">
          <span class=" font-bold text-[20px]">WEAVEMANILA INC.</span><br>
          <span class="text-[#281c0f] text-[12px]">Production Monitoring & Inventory Management System</span>

        </div>
    </div>



    <li class="font-bold">Overview</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/main-dashboard">
          <q-icon name="dashboard" class="mr-2"/> Dashboard
          </router-link>
        </div>
      </li>
      <!-- Process Section -->
      <li class="font-bold">Process</li>
      <li class="py-[10px] px-[20px]" @click="toggleInventoryMenu">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/> Inventory</div>
          <div><q-icon name="expand_more"/> </div>
        </div>
        <ul v-if="inventoryMenuVisible">
          <li class="py-[2px] px-[40px] mt-3">Purchase Order</li>
          <li class="px-[40px] mt-3">Supplier List</li>
        </ul>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2">
          <i class="bi bi-box-seam"></i> Product Monitoring
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <q-icon name="description" class="mr-2"/> Production Cost Report
        </div>
      </li>
      <!-- Settings Section -->
      <li class="font-bold">Settings</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/auditlogs-section">
            <i class="bi bi-activity"></i> Audit Logs
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/usermanagement-section">
            <q-icon name="group" class="mr-2"/> User Management
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/account-settings">
            <q-icon name="manage_accounts" class="mr-2"/> Account Settings
          </router-link>
        </div>
      </li>
      <li class="mt-auto py-[10px]">
        <div class="flex justify-between">
          <div class="flex items-center">
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
          <div class="flex items-center">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
          </div>
        </div>
      </li>
    </ul>
</q-drawer>
<q-page class="bg-[#f5f5f5] p-4">
    <div class="flex justify-between items-center">
      <div class="text-[30px]">
        <div class="items-center flex">
          <!-- First version of menu icon -->
          <q-icon
            name="menu"
            v-if="showMenuIcon"
            @click="toggleDrawer"
            class="cursor-pointer"
          />
          <!-- Second version of menu icon for smaller screens -->
          <q-icon
            name="menu"
            v-if="!showMenuIcon"
            @click="toggleDrawer"
            class="cursor-pointer min-[360px]:flex md:hidden"
          />
          <span class="font-bold">User Info</span>
        </div>
        <div class="text-[16px]">This section serves as a platform for managing user-related information.</div>
      </div>
    </div>
    <div class="md:w-[800px] h-[510px] mt-2 border border-[#dfc8c0] rounded p-5 text-[15px]">
      <q-form
        @submit="onSubmit"
      >
        <p class="text-[#9e896a] font-bold">Name</p>
        <div class="grid grid-cols-2 gap-4 mt-3">
            <q-input v-model="fname" label="First name" outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            <q-input v-model="lname" label="Last name" outlined dense  class=" rounded" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
        </div>
        <div class="md:w-[370px]">
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
</q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';

export default {
  setup() {
      const $q = useQuasar();

      return { $q };
  },
  data() {
    return {
      responseInformation: '',
      responseStatus: '',
      statusCheckTimer: null,
      email: '',
      userProfileImage: null,
      username: '',
      fullnames: '',
      fname: '',
      lname: '',

      firstname: '',
      middlename: '',
      lastname: '',
      gender: '',
      day: '',
      year: '',
      position: '',
      mobilenumber: '',
      password: '',
      status: '',
      arrowDirection: false,
      showModal: false,
      drawer: false,
      showMenuIcon: false,
      inventoryMenuVisible: false,
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
    this.statusCheckTimer = setInterval(() => {
    this.checkUserStatus();
    }, 5 * 1000); // 5 minutes (in milliseconds)
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
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

          this.position = userInformation.position;
          this.mobilenumber = userInformation.mobilenumber;
          this.password = userInformation.password;
          this.fname = userInformation.firstname;
          this.lname = userInformation.lastname;
          this.fullnames = this.firstname + " " + this.lastname;
          this.status = userInformation.status;
          if(this.status == 0)
          {
            this.$q.notify({
            type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }
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
    toggleDrawer() {
      this.drawer = !this.drawer;
      this.showMenuIcon = !this.showMenuIcon;
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
        return `/pfp/${this.userProfileImage}`;
      } else {
        // Return a default path or handle it as per your requirement
        return '/default_profile.png';
      }
    },
    toggleModal() {
      this.arrowDirection = !this.arrowDirection;
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
      const formData = {
        Firstname: this.fname,
        Lastname: this.lname,
        Day: this.day,
        Month: this.month,
        Year: this.year,
        Gender: this.gender,
      };
      axios.put(`http://localhost/Capstone-Project/backend/api/Account_Settings/basicinfo.php/${this.email}`, formData)
      .then((response) =>{
        this.responseStatus = response.data.status;
        this.responseInformation = response.data.information;
        if (this.responseStatus === "success") {
            const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
            existingInformation.firstname = this.responseInformation.firstname;
            existingInformation.lastname = this.responseInformation.lastname;
            existingInformation.birthdate = this.responseInformation.birthdate;
            existingInformation.gender = this.responseInformation.gender;
            this.$q.notify({
                message: 'Personal Information Updated!',
                caption: 'Your personal information has been changed successfully.',
                color: 'green',
            });

            SessionStorage.set('information', JSON.stringify(existingInformation));
            this.loadUserData();
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
