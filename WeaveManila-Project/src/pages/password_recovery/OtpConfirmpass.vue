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
              Create new password
            </h1>
            <p class="text-sm md:text-base text-gray-600">
              Your new password must be unique from those previously used.
            </p>
          </div>

          <!-- Form -->
          <q-form @submit="onSubmit" class="space-y-5">
            <!-- New Password Input -->
            <div>
              <q-input
                v-model="newPassword"
                label="New Password"
                :type="showPassword ? 'text' : 'password'"
                @input="validatePassword"
                outlined
                class="custom-input"
              >
                <template v-slot:append>
                  <q-icon
                    @click="togglePasswordVisibility"
                    :name="showPassword ? 'visibility_off' : 'visibility'"
                    class="cursor-pointer text-gray-500 hover:text-gray-700 transition-colors"
                  />
                </template>
              </q-input>
            </div>

            <!-- Confirm Password Input -->
            <div>
              <q-input
                v-model="confirmPassword"
                label="Confirm New Password"
                :type="showPassword ? 'text' : 'password'"
                @input="validatePassword"
                outlined
                class="custom-input"
              >
                <template v-slot:append>
                  <q-icon
                    @click="togglePasswordVisibility"
                    :name="showPassword ? 'visibility_off' : 'visibility'"
                    class="cursor-pointer text-gray-500 hover:text-gray-700 transition-colors"
                  />
                </template>
              </q-input>
            </div>

            <!-- Error Message -->
            <div v-if="passwordError" class="text-red-600 text-sm px-1">
              {{ passwordError }}
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
                label="Confirm"
                type="submit"
                :disable="passwordError !== ''"
                class="w-full bg-[#9e896a] hover:bg-[#8a7759] text-white font-semibold py-3 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                unelevated
                no-caps
              />
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
          alt="Create Password Illustration"
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

.q-btn:hover:not(:disabled) {
  transform: translateY(-1px);
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
