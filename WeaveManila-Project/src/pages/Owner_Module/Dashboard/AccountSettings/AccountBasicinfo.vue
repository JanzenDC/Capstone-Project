<template>
<div class="h-[510px] mt-2 border border-[#dfc8c0] rounded p-5 text-[15px] md:w-full">
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
        <div v-close-popup class="cursor-pointer bg-white rounded-full text-center p-2 text-[#9e896a] w-[74px] border-2 border-[#9e896a]">
          Cancel
        </div>
        <q-btn label="Save" type="submit" class="bg-[#9e896a] rounded-full  text-white"/>
      </div>
  </q-form>
</div>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';

export default {
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
              message: 'Your account is currently inactive. Please contact the administrator.',
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
            window.location.reload();
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
