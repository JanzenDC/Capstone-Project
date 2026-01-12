<template>
  <q-page class="flex flex-col lg:flex-row min-h-screen overflow-hidden">
    <!-- Left Container - Form -->
    <div class="flex-1 flex flex-col bg-white order-2 lg:order-1">
      <!-- Logo Section -->
      <div class="p-6 md:p-8 lg:p-10">
        <q-img
          src="../../assets/favicon-128x128.png"
          alt="Company Logo"
          class="w-[56px] md:w-[76px] lg:w-[86px]"
        />
      </div>

      <!-- Form Container -->
      <div class="flex-1 flex items-center justify-center px-6 md:px-12 lg:px-16 py-8">
        <div class="w-full max-w-[440px]">
          <!-- Back Link -->
          <div class="mb-6">
            <router-link 
              to="/forgot/reset"
              class="inline-flex items-center text-sm text-gray-600 hover:text-[#9e896a] transition-colors"
            >
              <q-icon name="arrow_back_ios" size="16px" class="mr-1"/>
              Back
            </router-link>
          </div>

          <!-- Header -->
          <div class="mb-8">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3">
              OTP Verification
            </h1>
            <p class="text-sm md:text-base text-gray-600">
              Enter the verification code we just sent to your email.
            </p>
          </div>

          <!-- Form -->
          <q-form @submit="verifyCode" class="space-y-5">
            <!-- OTP Input -->
            <div>
              <q-input
                v-model="otpCode"
                label="OTP Code"
                maxlength="6"
                @input="handleInputChange"
                :no-error-icon="true"
                :rules="[ val => val.length === 6 || 'Invalid OTP code length']"
                outlined
                class="custom-input"
                filled
              />
            </div>

            <!-- Error Message -->
            <div v-if="responseStatus === 'fail'" class="text-red-600 text-sm px-1">
              {{ responseMessage }}
            </div>

            <!-- Remember Password Link -->
            <div class="flex items-center gap-2">
              <p class="text-sm text-gray-600">Remember Password?</p>
              <router-link 
                to="/" 
                @click="clearSession"
                class="text-sm text-[#9e896a] hover:text-[#8a7759] font-medium transition-colors"
              >
                Login
              </router-link>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
              <q-btn 
                label="Verify" 
                type="submit" 
                class="w-full bg-[#9e896a] hover:bg-[#8a7759] text-white font-semibold py-3 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
                unelevated
                no-caps
              />
            </div>

            <!-- Resend Code Section -->
            <div class="pt-4 text-center">
              <p v-if="resendCountdown > 0" class="text-sm text-gray-600">
                Please wait for <span class="font-semibold text-[#9e896a]">{{ formatTime(resendCountdown) }}</span> before requesting a new code.
              </p>
              <p v-else class="text-sm text-gray-600">
                Didn't receive the code?
                <span @click="resendCode" class="resend-link ml-1">
                  Resend it now.
                </span>
              </p>
            </div>
          </q-form>
        </div>
      </div>
    </div>

    <!-- Right Container - Image -->
    <div class="flex-1 bg-[#9e896a] flex items-center justify-center p-6 md:p-10 lg:p-16 order-1 lg:order-2 min-h-[300px] lg:min-h-screen">
      <div class="w-full h-full max-w-[600px] max-h-[600px] lg:max-h-[700px]">
        <q-img
          src="../../assets/images/login_images.jpg"
          alt="OTP Verification Illustration"
          class="w-full h-full rounded-3xl shadow-2xl object-cover"
          fit="cover"
        />
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
      axios.post('http://localhost/Capstone-Project/backend/api/api.php', formData)

    },
    verifyCode() {

      const formData = {
        otpCode: this.otpCode,
        email: this.email
      };

      axios.post('http://localhost/Capstone-Project/backend/api/otpverification.php', formData)
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

<style scoped>
/* Custom input styling */
:deep(.custom-input .q-field__control) {
  height: 48px;
  border-radius: 8px;
}

:deep(.custom-input .q-field__native) {
  padding-top: 12px;
  padding-bottom: 12px;
}

:deep(.custom-input .q-field__label) {
  font-size: 14px;
}

:deep(.q-field__control):hover {
  border-color: #9e896a;
}

:deep(.q-field__control):focus-within {
  border-color: #9e896a;
}

.q-btn:hover {
  transform: translateY(-1px);
}

.resend-link {
  color: #9e896a;
  cursor: pointer;
  text-decoration: underline;
  font-weight: 500;
  transition: color 0.2s;
}

.resend-link:hover {
  color: #8a7759;
}

@media (max-width: 1023px) {
  .q-page {
    flex-direction: column;
  }
}

@media (max-height: 600px) and (orientation: landscape) {
  .flex-1.flex.flex-col.bg-white {
    min-height: auto;
  }
  
  .flex-1.bg-\[#9e896a\] {
    min-height: 250px;
  }
}
</style>
