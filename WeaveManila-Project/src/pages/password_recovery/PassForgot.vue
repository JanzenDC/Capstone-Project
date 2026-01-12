<template>
  <q-page class="flex flex-col lg:flex-row min-h-screen overflow-hidden">
    <!-- Left Container - Form -->
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
          <!-- Header -->
          <div class="mb-8">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3">
              Forgot Password?
            </h1>
            <p class="text-sm md:text-base text-gray-600">
              No worries, we'll send you reset instructions.
            </p>
          </div>

          <!-- Form -->
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
                label="Send Code" 
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
          src="../../assets/images/login_images.jpg"
          alt="Forgot Password Illustration"
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
      showPassword: false,
      responseStatus: null,
      responseMessage: '',
      responseEmail: '',
      responseCode: '',
      responseChangepass: '',
      companyimage: ''
    };
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
    clearSession() {
      sessionStorage.clear();
      this.$router.push('/');
    },
    ruleRequired(value) {
      return !!value || 'Password is required';
    },
    ruleEmail(value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(value) || 'Please enter a valid email address';
    },
    onSubmit() {
      const code = Math.floor(100000 + Math.random() * 900000);
      const formData = {
        email: this.email,
        code: code,
      };

      axios.post('http://localhost/Capstone-Project/backend/api/api.php', formData)
      .then(response => {
        console.log(response.data);
        this.responseStatus = response.data.status;
        this.responseMessage = response.data.message;

        const responseEmail = response.data.info.email;
        this.responseCode = response.data.info.code;
        this.responseChangepass = response.data.info.isChangingPass;

        if (this.responseStatus !== 'fail') {
          SessionStorage.set('email', JSON.stringify(responseEmail));

          SessionStorage.set('code', JSON.stringify(this.responseCode));

          SessionStorage.set('isChangingPass', JSON.stringify(this.responseChangepass));
          this.$router.push('/forgot/otp-verification');
        }
      })
      .catch(error => {
        console.error('Error submitting form:', error);
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
