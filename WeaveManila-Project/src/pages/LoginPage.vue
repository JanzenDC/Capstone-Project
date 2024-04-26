<template>
  <q-page class="md:flex bg-[#9e896a] relative ">
    <q-img
      src="../assets/images/login_images.jpg"
      alt="Description of the image"
      class=" min-[390px]:right-[30px] min-[390px]:top-[88px] w-[328px] md:w-[550px] absolute md:top-[50px] md:right-[250px] rounded-[32px]"
    />
    <div class="bg-[#9e896a]  md:bg-white md:w-[800px] p-4 h-64 md:h-screen">
      <q-img
        src="../assets/favicon-128x128.png"
        alt="Description of the image"
        class="w-[46px] md:w-[86px] mt-8"
      />
      <div class=" w-[550px]">
        <div class="p-4 mt-8 w-[340px] min-[390px]:hidden sm:hidden md:block">

          <div>
            <p class="text-[15px] ">Welcome to <span class="text-[#9e896a]">Online Production</span>
            <br><span class="text-[#9e896a]">Monitoring & Inventory Management</span>
            <br><span class="text-[#9e896a]">System!</span>
          </p>
          <p class="font-bold text-4xl mt-10">
            Login
          </p>
          <p>Enter your credentials to access your account</p>
          <q-form
            @submit="onSubmit"
            class="q-gutter-md mt-3"
          >
            <q-input
              v-model="email"
              label="Email"
              type="email"
              outlined
              dense
              :no-error-icon="true"
              :rules="[ruleEmail]"
            ></q-input>
            <q-input
              v-model="password"
              label="Password"
              :type="showPassword ? 'text' : 'password'"
              outlined
              dense
              :no-error-icon="true"
              :rules="[ruleRequired]"
            >
              <template v-slot:append>
                <q-icon
                  :name="showPassword ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="togglePasswordVisibility"
                />
              </template>
            </q-input>
            <div v-if="responseStatus === 'fail'" class="text-red-600 text-[11px]   mt-1 ms-7">
                  {{ responseMessage }}
            </div>
            <router-link to="/forgot/reset" class="text-right">Forgot password?</router-link>
            <div>
              <q-btn label="Login" type="submit" class="bg-[#9e896a] rounded-md w-full text-white"/>
            </div>
          </q-form>
          </div>
        </div>
      </div>
    </div>
    <div class="min-[390px]:bg-white h-screen md:bg-[#9e896a] ">
      <div class="p-4 mt-3 md:w-[340px] min-[390px]:block sm:block md:hidden">
          <div class="mt-[150px]">
            <p class="text-[16px] text-center">Welcome to <span class="text-[#9e896a]">Online Production</span>
            <br><span class="text-[#9e896a]">Monitoring & Inventory Management</span>
            <br><span class="text-[#9e896a]">System!</span>
          </p>
          <p class="font-bold text-[24px] mt-10">
            Login
          </p>
          <p class="text-[12px]">Enter your credentials to access your account</p>
          <q-form
            @submit="onSubmit"
            class="q-gutter-md mt-3"
          >
            <q-input
              v-model="email"
              label="Email"
              type="email"
              outlined
              dense
              :no-error-icon="true"
              :rules="[ruleEmail]"
            ></q-input>
            <q-input
              v-model="password"
              label="Password"
              :type="showPassword ? 'text' : 'password'"
              outlined
              dense
              :no-error-icon="true"
              :rules="[ruleRequired]"
            >
              <template v-slot:append>
                <q-icon
                  :name="showPassword ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="togglePasswordVisibility"
                />
              </template>
            </q-input>
            <div v-if="responseStatus === 'fail'" class="text-red-600 text-[11px]   mt-1 ms-7">
                  {{ responseMessage }}
            </div>
            <router-link to="/forgot/reset" ><span class="text-right">Forgot password?</span></router-link>
            <div>

              <q-btn label="Login" type="submit" class="bg-[#9e896a] rounded-md w-full text-white"/>
            </div>
          </q-form>
          </div>
        </div>
    </div>
  </q-page>


</template>

<script>
import { useQuasar } from 'quasar';
import AuthService from '../javascript/AuthService';

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
  methods: {
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
