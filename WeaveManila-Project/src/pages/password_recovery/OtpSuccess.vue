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
            <div class="flex justify-center items-center">
            <q-icon name="verified" class="text-[96px] text-green-600"/>
            </div>

            <p class="font-bold text-[31px] text-[#9e896a]"> Password Changed!</p>
            <p class="text-lg">Your password has been changed successfully.</p>
            <div class="bg-[#9e896a] text-white p-2 text-center rounded-md mt-3">
              <router-link to="/">
                Back to login
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="min-[320px]:bg-white h-screen md:bg-[#9e896a] ">
      <div class="p-4 mt-3 md:w-[340px] min-[320px]:block sm:block md:hidden">
        <div>
            <div class="flex justify-center items-center mt-[150px]">
            <q-icon name="verified" class="text-[96px] text-green-600"/>
            </div>

            <p class="font-bold text-[31px] text-[#9e896a]"> Password Changed!</p>
            <p class="text-lg">Your password has been changed successfully.</p>
            <div class="bg-[#9e896a] text-white p-2 text-center rounded-md mt-3">
              <router-link to="/">
                Back to login
              </router-link>
            </div>
          </div>
      </div>
    </div>
  </q-page>


</template>

<script>
import { useQuasar } from 'quasar';

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
    loadUserData() {
      const userData = SessionStorage.getItem('email');
      console.log("User Data from Session Storage:", userData);

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
  }
};
</script>
