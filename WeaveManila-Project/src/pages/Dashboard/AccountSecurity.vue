<template>
  <q-header elevated class="bg-white w-full text-black h-[100px]  md:flex md:justify-between border-2">

    <div class="md:w-[400px] p-4 md:flex min-[320px]:hidden">
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
    <div class="bg-white h-[520px] rounded p-4 px-7 overflow-auto">
      <h1 class="text-[25px] font-bold">Change Password</h1>
      <q-form @submit="onSubmit">
        <div class="w-full">
          <q-input
            :type="showPassword ? 'text' : 'password'"
            label="Current Password"
            outlined
            dense
            v-model="currentPW"
            class="w-[300px]"
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
          <div class="flex gap-16 mt-5">
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
          <p class="mt-2">To create new password, you have to meet all the following</p>
          <p class="mt-2">Your password must be at least 10 characters long.</p>
          <p class="mt-2">Include upper and lowercase then special characters, such as !, @, #, $, etc.</p>
          <p class="mt-2">Use at least one numerical digit.</p>
          <p class="mt-2">Cannot be the same as previous password</p>
        <div class="flex justify-end w-full gap-2 mt-3">
          <router-link
            to="/dashboard/account-settings"
            class="bg-white rounded-full text-center p-2 text-[#9e896a] w-[74px] border-2 border-[#9e896a]"
          >
            Cancel
          </router-link>
          <q-btn label="Save" type="submit" class="bg-[#9e896a] rounded-full text-white" />
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
  },
  data() {
    return {
      uid: '',
      email: '',
      firstname: '',
      middlename: '',
      lastname: '',
      userProfileImage: null,
      username: '',
      showModal: false,
      arrowDirection: false,
      position: '',
      drawer: false,

      currentPW: '',
      changePW: '',
      confirmPW: '',
      showPassword: false,
      showChangePassword: false,
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
  },
  methods: {

    loadUserData() {
      const userData = SessionStorage.getItem('information');

      if (userData) {
        try {
          const userInformation = JSON.parse(userData);
          this.uid = userInformation.uid;
          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;
          this.position = userInformation.position;
          this.password = userInformation.password;
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
        console.log(response.data);
        if (this.responseStatus === "success") {
            const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
            existingInformation.password = this.responseInformation.password;
            this.$q.notify({
                message: 'Password Updated!!',
                caption: 'Your password has been changed successfully.',
                color: 'green',
            });
            this.currentPW = null;
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

