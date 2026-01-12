<template>
  <q-page class="flex flex-col lg:flex-row min-h-screen overflow-hidden">
    <!-- Left Container - Success Message -->
    <div class="flex-1 flex flex-col bg-white order-2 lg:order-1">
      <!-- Logo Section -->
      <div class="p-6 md:p-8 lg:p-10">
        <q-img
          src="../../assets/favicon-128x128.png"
          alt="Company Logo"
          class="w-[56px] md:w-[76px] lg:w-[86px]"
        />
      </div>

      <!-- Content Container -->
      <div class="flex-1 flex items-center justify-center px-6 md:px-12 lg:px-16 py-8">
        <div class="w-full max-w-[440px] text-center">
          <!-- Success Icon -->
          <div class="flex justify-center items-center mb-8">
            <q-icon name="verified" class="text-[96px] md:text-[120px] text-green-600"/>
          </div>

          <!-- Success Message -->
          <div class="mb-8">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#9e896a] mb-4">
              Password Changed!
            </h1>
            <p class="text-base md:text-lg text-gray-600">
              Your password has been changed successfully.
            </p>
          </div>

          <!-- Back to Login Button -->
          <div class="pt-4">
            <router-link 
              to="/" 
              @click="clearSession"
              class="inline-block w-full bg-[#9e896a] hover:bg-[#8a7759] text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg text-center"
            >
              Back to login
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Container - Image -->
    <div class="flex-1 bg-[#9e896a] flex items-center justify-center p-6 md:p-10 lg:p-16 order-1 lg:order-2 min-h-[300px] lg:min-h-screen">
      <div class="w-full h-full max-w-[600px] max-h-[600px] lg:max-h-[700px]">
        <q-img
          src="../../assets/images/login_images.jpg"
          alt="Success Illustration"
          class="w-full h-full rounded-3xl shadow-2xl object-cover"
          fit="cover"
        />
      </div>
    </div>
  </q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';

export default {
  setup() {
    const $q = useQuasar();
  },
  mounted() {
    this.$nextTick(() => {
      this.loadUserData();
    });
  },
  methods: {
    clearSession() {
      // Add logic to clear the session
      // For example, if using sessionStorage:
      sessionStorage.clear();

      // Redirect to the login page
      this.$router.push('/');
    },
    loadUserData() {
      const userData = SessionStorage.getItem('email');
      const isChangingPass = SessionStorage.getItem('isChangingPass');

      if (userData) {
        try {
          const user = JSON.parse(userData);
          this.email = user;
          if (isChangingPass === '0') {
            this.$router.push('/');
            sessionStorage.clear();
          }
        } catch (error) {
          console.log('Error parsing user data:', error);
          this.$router.push('/');
          sessionStorage.clear();
        }
      } else {
        this.$router.push('/');
        sessionStorage.clear();
      }
    },
  }
};
</script>

<style scoped>
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
