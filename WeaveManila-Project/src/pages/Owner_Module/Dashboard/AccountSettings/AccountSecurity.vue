<template>
<div class="bg-white rounded p-4 px-7 overflow-auto">
  <q-form @submit="onSubmit">
    <div class="w-full">
      <q-input
        :type="showPassword ? 'text' : 'password'"
        label="Current Password"
        outlined
        dense
        v-model="currentPW"
        class="w-[205px]"
        :no-error-icon="true"
        :rules="[passwordsMatchRule]"
      >
        <template v-slot:append>
          <q-icon
            :name="showPassword ? 'visibility_off' : 'visibility'"
            @click="togglePasswordVisibility"
          />
        </template>
      </q-input>
      <div class="md:flex md:gap-16 md:mt-5">
        <q-input
        :type="showChangePassword ? 'text' : 'password'"
        label="Change Password"
        outlined
        dense
        v-model="changePW"
        class="w-[300px]"
        :no-error-icon="true"
        :rules="[passwordLengthRule, passwordStrengthRule, passwordsDoNotMatchRule]"
      >
        <template v-slot:append>
          <q-icon
            :name="showChangePassword ? 'visibility_off' : 'visibility'"
            @click="togglePasswordChange"
          />
        </template>
        </q-input>
        <q-input
          :type="showChangePassword ? 'text' : 'password'"
          label="Confirm Password"
          outlined
          dense
          v-model="confirmPW"
          class="w-[300px]"
          :no-error-icon="true"
          :rules="[passwordsDoNotMatchRule]"
        >
        </q-input>
      </div>
    </div>
      <p class="font-bold text-[16px]">Password Rules:</p>
      <p class="mt-2">● To create new password, you have to meet all the following</p>
      <p class="mt-2">● Your password must be at least 10 characters long.</p>
      <p class="mt-2">● Include upper and lowercase then special characters, such as !, @, #, $, etc.</p>
      <p class="mt-2">● Use at least one numerical digit.</p>
      <p class="mt-2">● Cannot be the same as previous password</p>
    <div class="flex justify-end w-full gap-2 mt-3">
      <div
        v-close-popup
        class="bg-white rounded-full text-center p-2 text-[#9e896a] w-[74px] border-2 border-[#9e896a]"
      >
        Cancel
      </div>
      <q-btn label="Save" type="submit" class="bg-[#9e896a] rounded-full text-white" />
    </div>
  </q-form>
</div>
</template>

<script>
import { SessionStorage } from 'quasar';
import axios from 'axios';
export default {
  data() {
    return {
      uid: '',
      email: '',
      firstname: '',
      middlename: '',
      lastname: '',
      userProfileImage: null,
      username: '',
      status: '',
      showModal: false,
      arrowDirection: false,
      position: '',
      drawer: false,

      currentPW: '',
      changePW: '',
      confirmPW: '',
      showPassword: false,
      showChangePassword: false,
      statusCheckTimer: null,
    };
  },
  computed: {
    passwordLengthRule() {
      return (value) => {
        this.isLengthValid = value.length >= 10;
        return this.isLengthValid || 'Your password must be at least 10 characters long.';
      };
    },
    passwordStrengthRule() {
      return (value) => {
        const strengthRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]).+$/;
        this.isStrengthValid = strengthRegex.test(value);
        return this.isStrengthValid || 'Include upper and lowercase, and special characters.';
      };
    },
    passwordsDoNotMatchRule() {
      return (value) => value === this.changePW || 'New Password and Confirm Password should be the same';
    },
    passwordsMatchRule() {
      return (value) => value !== this.changePW || 'Current Password and New Password should not be the same';
    },
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
          this.uid = userInformation.id;
          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;
          this.position = userInformation.position;
          this.password = userInformation.password;
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
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;

    },
    togglePasswordChange() {
      this.showChangePassword = !this.showChangePassword;
    },
    onSubmit() {
      const formData = {
        currentPass: this.currentPW,
        newpass: this.changePW,
      }
      axios.put(`http://localhost/Capstone-Project/backend/api/Account_Settings/changepassword.php/${this.uid}`, formData)
      .then((response) =>{
        this.responseStatus = response.data.status;
        this.responseInformation = response.data.information;
        if (this.responseStatus === "success") {
            const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
            existingInformation.password = this.responseInformation.password;
            this.$q.notify({
                message: 'Password Updated!!',
                caption: 'Your password has been changed successfully.',
                color: 'green',
            });
            this.currentPW = '';
            this.changePW = null;
            this.confirmPW = null;
            SessionStorage.set('information', JSON.stringify(existingInformation));
            this.loadUserData();
            this.$router.push('/dashboard/account-changepass');
        }
        if (this.responseStatus === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${response.data.message} Please try again.`,
          });
        }
      }).catch(error => {
        console.error('Error submitting form:', error);
      });
    },
    logout() {
      sessionStorage.clear();
      this.$router.push('/');
    },
  },
};
</script>

