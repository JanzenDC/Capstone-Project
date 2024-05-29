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
          <p class="font-bold text-[30px] mt-10">
            OTP Verification
          </p>

          <p>Enter the verification code we just sent to your email.</p>
          <q-form @submit="verifyCode" class="q-gutter-md mt-3">
            <div class="mt-4 flex gap-2">
            <q-input :no-error-icon="true" class="w-full" filled v-model="otpCode" label="OTP Code" maxlength="6" @input="handleInputChange" :rules="[ val => val.length === 6 || 'Invalid OTP code length']"> </q-input>
            </div>
            <div v-if="responseStatus === 'fail'" class="text-red-600 text-[11px]   mt-1 ms-7">
                  {{ responseMessage }}
            </div>
            <div class="flex gap-2">
              <p class="text-[12px] mt-[3px]">Remember Password?</p>
              <router-link to="/" @click="clearSession"><span class="text-[12px] font-bold">Login</span></router-link>
            </div>
            <div>
              <q-btn label="Verify" type="submit" class="bg-[#9e896a] rounded-md w-full text-white"/>
            </div>
              <p v-if="resendCountdown > 0">
                Please wait for {{ formatTime(resendCountdown) }} before requesting a new code.
              </p>
              <p v-else>
                  Didn't receive the code?
                <span @click="resendCode" class="resend-link">
                  Resend it now.
                </span>
              </p>
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
            <p class="font-bold text-[30px] mt-10">
              OTP Verification
            </p>

            <p>Enter the verification code we just sent to your email.</p>
            <q-form @submit="verifyCode" class="q-gutter-md mt-3">
              <div class="mt-4 flex gap-2">
              <q-input  :no-error-icon="true" class="w-full" filled v-model="otpCode" label="OTP Code" maxlength="6" @input="handleInputChange" :rules="[ val => val.length === 6 || 'Invalid OTP code length']"> </q-input>
              </div>
              <div v-if="responseStatus === 'fail'" class="text-red-600 text-[11px]   mt-1 ms-7">
                  {{ responseMessage }}
              </div>
              <div class="flex gap-2">
                <p class="text-[12px] mt-[3px]">Remember Password?</p>
                <router-link to="/" @click="clearSession"><span class="text-[12px] font-bold">Login</span></router-link>
              </div>
              <div>
                <q-btn label="Verify" type="submit" class="bg-[#9e896a] rounded-md w-full text-white"/>
              </div>
              <p v-if="resendCountdown > 0">
                Please wait for {{ formatTime(resendCountdown) }} before requesting a new code.
              </p>
              <p v-else>
                Didn't receive the code?
              <span @click="resendCode" class="resend-link">
                Resend it now.
              </span>
              </p>

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
      otpCode: '',
      responseStatus: null,
      responseMessage: '',
      responsePassword: '',
      resendTimer: null,
      resendCountdown: '',
      isResendDisabled: false,
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.loadUserData();
      this.startResendTimer();
      this.isResendDisabled = true;
    });
  },

  methods: {
    clearSession() {
      sessionStorage.clear();
      this.$router.push('/');
    },
    startResendTimer() {
      this.resendCountdown = 60;
      this.resendTimer = setInterval(() => {
        if (this.resendCountdown > 0) {
          this.resendCountdown--;
        } else if (this.resendCountdown == 0){
          this.stopResendTimer();
          this.isResendDisabled = false;
        }
      }, 1000);
    },
    stopResendTimer() {
      clearInterval(this.resendTimer);
      this.resendCountdown = 0; // Set the countdown to 0 when stopping the timer
    },
    handleInputChange(value) {
      console.log('Input value changed:', value);
      if (value.length === 6) {
        console.log('Valid OTP code entered');
      } else {
        console.log('Invalid OTP code length')
      }
    },
    formatTime(seconds) {
      const minutes = Math.floor(seconds / 60);
      const remainingSeconds = seconds % 60;
      return `${minutes}m ${remainingSeconds}s`;
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
    resendCode() {
      this.startResendTimer();
      this.isResendDisabled = true;
      const code = Math.floor(100000 + Math.random() * 900000);
      const formData = {
        email: this.email,
        code: code,
      };
      axios.post('https://weavemanila.optikl.ink/backend/api/api.php', formData)

    },
    verifyCode() {

      const formData = {
        otpCode: this.otpCode,
        email: this.email
      };

      axios.post('https://weavemanila.optikl.ink/backend/api/otpverification.php', formData)
        .then(response => {
          this.responseStatus = response.data.status;
          this.responseMessage = response.data.message;

          if (this.responseStatus !== 'fail') {
              this.$router.push('/forgot/otp-changepass');
          }
        })
        .catch(error => {
          console.error('Verification failed:', error);
        });
    },


  },
};
</script>
<style>
.resend-link {
  color: blue;
  cursor: pointer;
  text-decoration: underline;
}
</style>
