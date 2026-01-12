<template>
  <q-page class="flex flex-col lg:flex-row min-h-screen overflow-hidden">
    <!-- Left Container - Sign In Form -->
    <div class="flex-1 flex flex-col bg-white order-2 lg:order-1">
      <!-- Logo Section -->
      <div class="p-6 md:p-8 lg:p-10">
        <q-img
          :src="getCompanyImagePath()"
          alt="Company Logo"
          class="w-[56px] md:w-[76px] lg:w-[86px]"
        />
      </div>

      <!-- Form Container -->
      <div class="flex-1 flex items-center justify-center px-6 md:px-12 lg:px-16 py-8">
        <div class="w-full max-w-[440px]">
          <!-- Welcome Text -->
          <div class="mb-8 md:mb-10">
            <p class="text-sm md:text-base text-gray-700 leading-relaxed">
              Welcome to <span class="text-[#9e896a] font-semibold">Online Production<br>Monitoring & Inventory Management<br>System!</span>
            </p>
          </div>

          <!-- Login Header -->
          <div class="mb-8">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3">
              Login
            </h1>
            <p class="text-sm md:text-base text-gray-600">
              Enter your credentials to access your account
            </p>
          </div>

          <!-- Login Form -->
          <q-form @submit="onSubmit" class="space-y-5">
            <!-- Email Input -->
            <div>
              <q-input
                v-model="email"
                label="Email"
                type="email"
                outlined
                :no-error-icon="true"
                :rules="[ruleEmail]"
                class="custom-input"
              />
            </div>

            <!-- Password Input -->
            <div>
              <q-input
                v-model="password"
                label="Password"
                :type="showPassword ? 'text' : 'password'"
                outlined
                :no-error-icon="true"
                :rules="[ruleRequired]"
                class="custom-input"
              >
                <template v-slot:append>
                  <q-icon
                    :name="showPassword ? 'visibility_off' : 'visibility'"
                    class="cursor-pointer text-gray-500 hover:text-gray-700 transition-colors"
                    @click="togglePasswordVisibility"
                  />
                </template>
              </q-input>
            </div>

            <!-- Error Message -->
            <div v-if="responseStatus === 'fail'" class="text-red-600 text-sm px-1">
              {{ responseMessage }}
            </div>

            <!-- Forgot Password Link -->
            <div class="flex justify-end">
              <router-link
                to="/forgot/reset"
                class="text-sm text-[#9e896a] hover:text-[#8a7759] font-medium transition-colors"
              >
                Forgot password?
              </router-link>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
              <q-btn
                label="Login"
                type="submit"
                class="w-full bg-[#9e896a] hover:bg-[#8a7759] text-white font-semibold py-3 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
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
          src="../assets/images/login_images.jpg"
          alt="Login Illustration"
          class="w-full h-full rounded-3xl shadow-2xl object-cover"
          fit="cover"
        />
      </div>
    </div>
  </q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import AuthService from '../javascript/AuthService';
import axios from 'axios';

export default {
  setup() {
    const $q = useQuasar();
  },
  data() {
    return {
      email: '', // This is where the email will be stored
      password: '', // This is where the password will be stored
      showPassword: false,
      responseMessage: '',
      responseStatus: '',
      responseInformation: {},
      isOnline: '',
      companyimage: ''
    };
  },
  beforeRouteEnter(to, from, next) {
    // Check if the user is logged in
    if (AuthService.isLoggedIn()) {
      // If logged in, redirect to the dashboard
      next('/dashboard/main-dashboard');
    } else {
      // If not logged in, proceed to the login page
      next();
    }
  },
  mounted() {
    this.fetchImageLogo();
  },
  methods: {
    getCompanyImagePath() {
      // Ensure userProfileImage is not null before creating the path
      if (this.companyimage) {
        return `/Logo/${this.companyimage}`;
      }else if (this.companyimage == '') {
        // Return a default path or handle it as per your requirement
        return '/Logo/default_logo.png';
      }
      else {
        // Return a default path or handle it as per your requirement
        return '/Logo/default_logo.png';
      }
    },
    fetchImageLogo(){
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=companylogo`)
      .then(response => {
          console.log('selectAdmin', response.data.isAdmin);
          this.companyimage = response.data.isAdmin.company_logo;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    ruleRequired(value) {
      return !!value || 'Password is required';
    },
    ruleEmail(value) {
      // Basic email validation using a regular expression
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(value) || 'Please enter a valid email address';
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },

    onSubmit() {
      AuthService.login(this.email, this.password)
      .then(information => {
          this.$router.push('/dashboard/main-dashboard');
        })
        .catch(error => {
          console.log(error.message)
          console.error('Login failed:', error.message);
          // Optionally, display an error message
          this.$q.notify({
            color: 'negative',
            position: 'bottom',
            message: 'Login failed. Please check your credentials.',
          });
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

/* Smooth transitions */
:deep(.q-field__control):hover {
  border-color: #9e896a;
}

:deep(.q-field__control):focus-within {
  border-color: #9e896a;
}

/* Button hover effect */
.q-btn:hover {
  transform: translateY(-1px);
}

/* Responsive adjustments */
@media (max-width: 1023px) {
  .q-page {
    flex-direction: column;
  }
}

/* Mobile landscape optimization */
@media (max-height: 600px) and (orientation: landscape) {
  .flex-1.flex.flex-col.bg-white {
    min-height: auto;
  }

  .flex-1.bg-\[#9e896a\] {
    min-height: 250px;
  }
}
</style>
