<template>
<div class="md:w-full md:h-[390px] mt-2 border border-[#dfc8c0] rounded p-5 text-[15px]">

      <p class="text-[#9e896a] font-bold">Email</p>
      <q-input outlined bottom-slots v-model="email" label="Email" disable>
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
        <q-card style="width: 350px">
          <q-card-section>
            <div class="text-h6">Otp Verification</div>
          </q-card-section>

          <q-card-section class="q-pt-none p-4">
            <div class="text-3xl flex justify-start items-center gap-2">
              <q-icon name="check_circle" color="green" />
              <p class="text-[15px]">Confirm Email Address</p>
            </div>
            <q-form @submit="onValidating">
              <div class="text-3xl flex justify-start items-center gap-2">
                <q-icon name="radio_button_unchecked" color="red" />
                <p class="text-[15px]">Validating OTP</p>
              </div>
              <q-input
                v-model="otpVal"
                label="OTP Code"
                type="number"
                filled
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
            <div class="text-3xl flex justify-start items-center gap-2">
              <q-icon name="check_circle" color="green" />
              <p class="text-[15px]">Confirm Email Address</p>
            </div>
            <div class="text-3xl flex justify-start items-center gap-2">
              <q-icon name="check_circle" color="green" />
              <p class="text-[15px]">Validating OTP</p>
            </div>
            <div class="text-3xl flex justify-start items-center gap-2">
              <q-icon name="radio_button_unchecked" color="red" />
              <p class="text-[15px]">Change Email</p>
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

</template>

<script>
import { SessionStorage } from 'quasar';
import axios from 'axios';

export default {
  data() {
    return {
      responseInformation: '',
      responseStatus: '',
      uid: '',
      email: '',
      status: '',
      firstname: '',
      position: '',
      userProfileImage: null,
      mobilenumber: '',
      arrowDirection: false,
      showModal: false,
      fullnames: '',
      drawer: false,
      inventoryMenuVisible: false,
      small: false,
      otpDialog: false,
      changeEmail: false,
      code: '',
      // Validating OTP
      otpVal: null,
      // ChangeEmail Properties
      currentEmail: '',
      newEmail: '',
      confirmNewEmail: '',
      statusCheckTimer: null,
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
          this.uid = userInformation.id;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;
          this.position = userInformation.position;
          this.mobilenumber = userInformation.mobilenumber;
          this.code = userInformation.otp_code;
          this.status = userInformation.status;
          this.fullnames = this.firstname + " " + this.lastname;
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
        } catch (error) {
          console.error('Error parsing user data:', error);
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
    onNewEmail(){
      const formData = {
        oldEmail: this.email,
        newEmail: this.newEmail,
        type: 3,
      }
      axios.post(`http://localhost/Capstone-Project/backend/api/Account_Settings/contactinfo.php`, formData)
      .then((response) => {

        this.responseStatus = response.data.status;
        this.responseInformation = response.data.information;
        if (this.responseStatus === "success") {
          this.small = false;
          this.otpDialog = false;
          this.changeEmail = false;
          this.$q.notify({
            color: 'green',
            message: `${response.data.message}`,
          });
          const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
          existingInformation.email = this.responseInformation.email;
          SessionStorage.set('information', JSON.stringify(existingInformation));
          this.loadUserData();
            window.location.reload();
        }
        if (this.responseStatus === "fail") {
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
    onChangeEmail(){
      if(this.email === this.currentEmail){
        const code = Math.floor(100000 + Math.random() * 900000);
        const formsData = {
          Email: this.currentEmail,
          code: code,
          type: 1,
        };
        axios.post(`http://localhost/Capstone-Project/backend/api/Account_Settings/contactinfo.php`, formsData)
        .then((response) =>{
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
