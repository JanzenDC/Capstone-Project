<template>
  <q-page class="md:flex bg-[#9e896a] relative ">
    <q-img
      src="../../assets/images/login_images.jpg"
      alt="Description of the image"
      class=" min-[320px]:right-[16px] min-[320px]:top-[88px] w-[328px] md:w-[550px] absolute md:top-[50px] md:right-[250px] rounded-[32px]"
    />
    <div class="bg-[#9e896a]  md:bg-white md:w-[800px] p-4 h-64 md:h-screen">
      <q-img
      :src="getCompanyImagePath()"
      alt="Description of the image"
      class="w-[46px] md:w-[96px]"
      />
      <div class="flex justify-center items-center w-[550px]">
        <div class="p-4 mt-3 w-[340px] min-[320px]:hidden sm:hidden md:block">
          <div>

          <p class="font-bold text-[30px]">

            Forgot Password?
          </p>
          <p>No worries, we’ll send you reset instructions.</p>
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
            <div v-if="responseStatus === 'fail'" class="text-red-600 text-[11px]   mt-1 ms-7">
              {{ responseMessage }}
            </div>
              <div class="flex gap-2">
                <p class="text-[12px] mt-[3px]">Remember Password?</p><router-link to="/" @click="clearSession"><span class="text-[12px] font-bold">Login</span></router-link>
              </div>
            <div>

              <q-btn label="Send Code" type="submit" class="bg-[#9e896a] rounded-md w-full text-white"/>
            </div>
          </q-form>

          </div>
        </div>
      </div>
    </div>
    <div class="min-[320px]:bg-white h-screen md:bg-[#9e896a] ">
      <div class="p-4 mt-3 md:w-[340px] min-[320px]:block sm:block md:hidden">
          <div class="mt-[150px]">
            <p class="font-bold text-[30px]">
            Forgot Password?
            </p>
            <p>No worries, we’ll send you reset instructions.</p>
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
                <div v-if="responseStatus === 'fail'" class="text-red-600 text-[11px]   mt-1 ms-7">
                  {{ responseMessage }}
                </div>
                <div class="flex gap-2">
                  <p class="text-[12px] mt-[3px]">Remember Password?</p><router-link to="/" @click="clearSession"><span class="text-[12px] font-bold">Login</span></router-link>
                </div>
              <div>

                <q-btn label="Send Code" type="submit" class="bg-[#9e896a] rounded-md w-full text-white"/>
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
      axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=companylogo`)
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

      axios.post('https://weavemanila.optikl.ink/backend/api/api.php', formData)
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
