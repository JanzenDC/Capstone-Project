<template>
  <q-page class="md:flex bg-[#9e896a] relative ">
    <q-img
      src="../../assets/images/login_images.jpg"
      alt="Description of the image"
      class=" min-[320px]:right-[16px] min-[320px]:top-[88px] w-[328px] md:w-[550px] absolute md:top-[50px] md:right-[250px] rounded-[32px]"
    />
    <div class="bg-[#9e896a]  md:bg-white md:w-[800px] p-4 h-64 md:h-screen">
      <q-img
      src="../../assets/favicon-128x128.png"
      alt="Description of the image"
      class="w-[46px] md:w-[96px]"
      />
      <div class="flex justify-center items-center w-[550px]">
        <div class="p-4 mt-3 w-[340px] min-[320px]:hidden sm:hidden md:block">
          <div>
          <div class="mt-10">
            <router-link to="/forgot/reset"><span class="text-[12px] font-bold"><q-icon name="arrow_back_ios" class="-mt-1"/> Back</span></router-link>
          </div>
          <p class="font-bold text-[25px]">
            Create new password
          </p>

          <p>Your new password must be unique from those previously used.</p>
          <q-form @submit="onSubmit" class="q-gutter-md mt-3">
            <q-input
              v-model="newPassword"
              label="New Password"
              :type="showPassword ? 'text' : 'password'"
              outlined
              dense
            >
              <template v-slot:append>
                <q-icon
                  @click="togglePasswordVisibility"
                  :name="showPassword ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                />
              </template>
            </q-input>

            <q-input
              v-model="confirmPassword"
              label="Confirm New Password"
              type="password"
              outlined
              dense
            />
            <div class=" text-red-600 text-[11px]" v-if="passwordError" >
              {{ passwordError }}
            </div>
            <div class="flex gap-2 mt-4">
              <p class="text-[12px] mt-[3px]">Remember Password?</p>
              <router-link to="/" @click="clearSession"><span class="text-[12px] font-bold">Login</span></router-link>
            </div>
            <div>
              <q-btn label="Confirm" type="submit" class="bg-[#9e896a] rounded-md w-full text-white"/>
            </div>
          </q-form>
          </div>
        </div>
      </div>
    </div>
    <div class="min-[320px]:bg-white h-screen md:bg-[#9e896a] ">
      <div class="p-4 mt-3 md:w-[340px] min-[320px]:block sm:block md:hidden">
          <div class="mt-[150px]">
            <div class="mt-10">
            <router-link to="/forgot/reset"><span class="text-[12px] font-bold"><q-icon name="arrow_back_ios" class="-mt-1"/> Back</span></router-link>
          </div>
          <p class="font-bold text-[25px]">
            Create new password
          </p>

          <p>Your new password must be unique from those previously used.</p>
          <q-form @submit.prevent="onSubmit" class="q-gutter-md mt-3">
            <q-input
              v-model="newPassword"
              label="New Password"
              :type="showPassword ? 'text' : 'password'"
              @input="validatePassword"
              outlined
              dense
            >
              <template v-slot:append>
                <q-icon
                  @click="togglePasswordVisibility"
                  :name="showPassword ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                />
              </template>
            </q-input>
            <q-input
              v-model="confirmPassword"
              label="Confirm New Password"
              type="password"
              @input="validatePassword"
              outlined
              dense
            />
            <div class=" text-red-600 text-[11px]" v-if="passwordError" >
              {{ passwordError }}
            </div>
            <div class="flex gap-2 mt-4">
              <p class="text-[12px] mt-[3px]">Remember Password?</p>
              <router-link to="/" @click="clearSession"><span class="text-[12px] font-bold">Login</span></router-link>
            </div>
            <div>
              <q-btn label="Confirm" type="submit" class="bg-[#9e896a] rounded-md w-full text-white" :disable="passwordError !== ''" />
            </div>
            <div>

            </div>
          </q-form>
          </div>
        </div>
    </div>
  </q-page>


</template>

<script>
import { useQuasar } from 'quasar';
import axios from 'axios';
import { SessionStorage } from 'quasar';

export default {
  setup() {
    const $q = useQuasar();
  },
  data() {
    return {
      email: '',
      newPassword: '',
      confirmPassword: '',
      passwordError: '',
      showPassword: false,

    };
  },
  mounted() {
    this.$nextTick(() => {
      this.loadUserData();
      this.isResendDisabled = true; // Disable the resend button during the countdown
    });
  },
  methods: {
  clearSession() {
    sessionStorage.clear();
    this.$router.push('/');
  },
  togglePasswordVisibility() {
    this.showPassword = !this.showPassword;
  },
  loadUserData() {
    const userData = SessionStorage.getItem('email');
    const isChangingPass = SessionStorage.getItem('isChangingPass');

    if (userData) {
      try {
        const user = JSON.parse(userData);
        this.email = user;

        if (isChangingPass === '0') {
          this.$router.push('/forgot/reset');
        }
      } catch (error) {
        console.log('Error parsing user data:', error);
        this.$router.push('/forgot/reset');
      }
    } else {
      this.$router.push('/forgot/reset');
    }
  },
  validatePassword() {
    this.passwordError = '';

    if (this.newPassword.length < 8) {
      this.passwordError = 'Password must be at least 8 characters long';
      return false;
    }

    if (this.newPassword !== this.confirmPassword) {
      this.passwordError = 'Passwords do not match';
      return false;
    }
  },

  onSubmit() {

    const formData = {
      newPassword: this.newPassword,
      confirmPassword: this.confirmPassword,
      email: this.email,
    };
    axios.post('http://localhost/Capstone-Project/backend/api/otpchangepass.php', formData)
      .then((response) => {
        this.responseStatus = response.data.status;
        if (this.responseStatus === 'success') {
            this.$router.push('/forgot/otp-success');
            SessionStorage.clear();
        }

      })
      .catch((error) => {
        // Handle the error response
        console.error('Error:', error);
      })
    }
  },
};
</script>
<style scoped>
.eye-icon {
  position: absolute;
  right: 15px;
  top: 15px;
  cursor: pointer;
  color: #888; /* Change color as needed */
}
</style>
