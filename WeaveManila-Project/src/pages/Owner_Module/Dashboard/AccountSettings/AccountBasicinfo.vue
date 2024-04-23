<template>
<div class="h-[510px] rounded p-3 text-[15px] md:w-full">
  <q-form
    @submit="onSubmit"
  >
    <p class="text-[#9e896a] font-bold">Name</p>
    <div class="grid grid-cols-2 gap-4 mt-3">
        <q-input v-model="fname" label="First name" outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
        <q-input v-model="lname" label="Last name" outlined dense  class=" rounded" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
    </div>
    <div class="grid grid-cols-2 gap-3">
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
    <div class="md:w-[370px]">
      <div class="">
        <p class="text-[#9e896a] font-bold">Email</p>
        <q-input dense outlined bottom-slots v-model="email" disable>
          <template v-slot:after>
            <q-icon name="edit" @click="small = true"/>
          </template>
        </q-input>
        <q-dialog
          v-model="small"
        >
          <q-card style="width: 350px">
            <q-card-section>
              <div class="text-h6">Change Email</div>
            </q-card-section>

            <q-card-section class="q-pt-none p-4">
              <div class="flex justify-between items-center mb-3">
                <div class="flex items-center">
                  <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-gray-300 text-gray-500">
                    1
                  </div>
                </div>
                <div class="h-px bg-gray-300 flex-grow"></div>
                <div class="flex items-center">
                  <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-gray-300 text-gray-500">
                    2
                  </div>
                </div>
                <div class="h-px bg-gray-300 flex-grow"></div>
                <div class="flex items-center">
                  <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-gray-300 text-gray-500">
                    3
                  </div>
                </div>
              </div>
              <q-form @submit="onChangeEmail">
                Kindly provide your current email address.
                <q-input
                  v-model="currentEmail"
                  label="Current Email Address"
                  type="email"
                  filled
                  class="mt-3"
                  :no-error-icon="true"
                  :rules="[ruleEmail]"
                ></q-input>
                <q-btn label="Send Code" type="submit" class="bg-[#9e896a] rounded-md w-full text-white mt-4"/>
              </q-form>
            </q-card-section>

            <q-card-actions align="right" class="bg-white text-teal">
              <q-btn flat label="Cancel" @click="cancelButtonClick" v-close-popup />
            </q-card-actions>
          </q-card>
        </q-dialog>

        <!-- Validating -->
        <q-dialog
          v-model="otpDialog"
        >
          <q-card style="width: 450px">
            <q-card-section>
              <div class="text-h6">Otp Verification</div>
            </q-card-section>

            <q-card-section class="q-pt-none p-4">
              <div class="flex justify-between items-center">
                <div class="flex items-center">
                  <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-[#9e896a] text-white bg-[#9e896a]">
                    1
                  </div>
                </div>
                <div class="h-px bg-[#9e896a] flex-grow"></div>
                <div class="flex items-center">
                  <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-gray-300 text-gray-500">
                    2
                  </div>
                </div>
                <div class="h-px bg-gray-300 flex-grow"></div>
                <div class="flex items-center">
                  <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-gray-300 text-gray-500">
                    3
                  </div>
                </div>
              </div>

              <q-form @submit="onValidating">
                <p>Note: Please input the OTP code sent to your email to continue changing your email.</p>
                <q-input
                  v-model="otpVal"
                  label="OTP Code"
                  type="number"
                  dense outlined
                  class="mt-3"
                  :no-error-icon="true"
                  :rules="[validateOtp]"
                ></q-input>
                <q-btn label="Submit" type="submit" class="bg-[#9e896a] rounded-md w-full text-white mt-4"/>
              </q-form>
            </q-card-section>

            <q-card-actions align="right" class="bg-white text-teal">
              <q-btn flat label="Cancel" @click="cancelButtonClick" v-close-popup />
            </q-card-actions>
          </q-card>
        </q-dialog>

        <!-- Changing Email -->
        <q-dialog
          v-model="changeEmail"
        >
          <q-card style="width: 500px">
            <q-card-section>
              <div class="text-h6">Change Email</div>
            </q-card-section>

            <q-card-section class="q-pt-none p-4">
              <div class="flex justify-between items-center mt-3 mb-3">
                <div class="flex items-center">
                  <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-[#9e896a] text-white bg-[#9e896a]">
                    1
                  </div>
                </div>
                <div class="h-px bg-[#9e896a] flex-grow"></div>
                <div class="flex items-center">
                  <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-[#9e896a] text-white bg-[#9e896a]">
                    2
                  </div>
                </div>
                <div class="h-px bg-[#9e896a] flex-grow"></div>
                <div class="flex items-center">
                  <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-gray-300 text-gray-500">
                    3
                  </div>
                </div>
              </div>

              <q-form @submit="onNewEmail">
                Please enter your new email address.
                <q-input
                  v-model="newEmail"
                  dense outlined
                  label="New Email Address"
                  type="email"
                  :rules="[val => !!val || 'Email is required', val => /.+@.+\..+/.test(val) || 'Invalid email']"
                  lazy-rules
                />

                <!-- Re-enter new email for confirmation -->
                <q-input
                  v-model="confirmNewEmail"
                  dense outlined
                  label="Confirm New Email Address"
                  type="email"
                  :rules="[val => !!val || 'Confirmation email is required', val => val === newEmail || 'Email addresses do not match']"
                  lazy-rules
                />
                <q-btn label="Confirm" type="submit" class="bg-[#9e896a] rounded-md w-full text-white mt-4"/>

              </q-form>
            </q-card-section>

            <q-card-actions align="right" class="bg-white text-teal">
              <q-btn flat label="Cancel" @click="cancelButtonClick" v-close-popup />
            </q-card-actions>
          </q-card>
        </q-dialog>
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

      small: false,
      otpDialog: false,
      changeEmail: false,
      code: '',
      // Validating OTP
      otpVal: null,
      // ChangeEmail Properties
      currentEmail: '',
      newEmail: '',
      confirmNewEmail: ''
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

          this.gender = userInformation.gender;

          this.position = userInformation.position;
          this.mobilenumber = userInformation.mobilenumber;
          this.password = userInformation.password;
          this.fname = userInformation.firstname;
          this.lname = userInformation.lastname;
          this.fullnames = this.firstname + " " + this.lastname;
          this.status = userInformation.status;
          this.currentEmail = userInformation.email;
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
    onValidating(){
      const formData = {
        otpVal: this.otpVal,
        userEmail: this.currentEmail,
        type: 2,
      };
      axios.post(`http://localhost/Capstone-Project/backend/api/Account_Settings/contactinfo.php`, formData)
      .then((response) => {
        this.responseStatus = response.data.status;
        this.responseInformation = response.data.information;
        if (this.responseStatus === "success") {
          this.small = false;
          this.otpDialog = false;
          this.changeEmail = true;
          this.loadUserData();
        }
        if (this.responseStatus === "fail") {
          // Notify when the status is "fail" with the response message
          this.$q.notify({
            color: 'negative',
            message: `${response.data.message} Please try again.`,
          });
        }
      })
      .catch((error) => {
        console.error("Error submitting form:", error);
      });

    },
    cancelButtonClick() {
      // Reset the values when the Cancel button is clicked
      this.otpVal = null;
      this.currentEmail = '';
      this.newEmail = '';
      this.confirmNewEmail = '';
    },
    validateOtp(value) {
      if (!value) {
        return "OTP Code is required.";
      }

      if (!/^\d+$/.test(value)) {
        return "OTP Code must contain only numerical digits.";
      }

      if (value.length !== 6) {
        return "OTP Code must be exactly 6 digits.";
      }
      return true;
    },
    ruleEmail(value) {
      // Basic email validation using a regular expression
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(value) || 'Please enter a valid email address';
    },
    onChangeEmail(){
      console.log(this.currentEmail)
      if(this.email === this.currentEmail){
        const code = Math.floor(100000 + Math.random() * 900000);
        const formsData = {
          Email: this.currentEmail,
          code: code,
          type: 1,
        };
        axios.post(`http://localhost/Capstone-Project/backend/api/Account_Settings/contactinfo.php`, formsData)
        .then((response) =>{
          console.log(response.data)
          this.responseStatus = response.data.status;
          this.responseInformation = response.data.information;
          if (this.responseStatus === "success") {

              this.small = false;
              this.otpDialog = true;
              const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
              existingInformation.otp_code = this.responseInformation.otp_code;
              this.$q.notify({
                  message: 'OTP Code Send!',
                  caption: 'An OTP (One-Time Password) code has been successfully sent for authentication.',
                  color: 'green',
              });
              SessionStorage.set('information', JSON.stringify(existingInformation));
              this.loadUserData();
          }
        }).catch(error => {
          console.error('Error submitting form:', error);
        });
      }else{
        this.$q.notify({
            message: "Email Denied",
            caption: 'The email you entered does not match the one previously provided.',
            color: 'red',
        });
      }

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
