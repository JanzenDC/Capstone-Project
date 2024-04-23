<template>
<div class='flex items-center'>
  <q-img
    :src="getUserProfileImagePath()"
    alt="Description of the image"
    class="w-12 md:w-12 rounded-full"
  />
  <q-icon :name="modalVisible ? 'keyboard_arrow_up' : 'keyboard_arrow_down'" size='md' @click="toggleModals" />
  <div v-show="modalVisible" class="fixed right-3 -top-[150px] overflow-y-auto z-50" @click="toggleModals">
    <div class="flex items-center justify-center min-h-screen">
      <div class="bg-white rounded-lg shadow-xl text-[16px]">
        <div class='bg-[#291B0E] w-full h-[50px] rounded-lg'>
        </div>
        <div class='p-4 px-2 relative '>
          <q-img
            :src="getUserProfileImagePath()"
            alt="Description of the image"
            class="w-12 md:w-14 rounded-full absolute -top-[30px] left-[64px] "
          />
          <div class='mt-4'>
            <div class='text-center mb-2'>
              {{ getLimitedFullname(fullname, 25) }}
            </div>
            <router-link to="/dashboard/account-settings" class='p-2'>
              <q-icon name="settings" class="mr-2"/> <span >Account Settings</span>
            </router-link>
            <div @click="OpenLogout = true" class='flex items-center cursor-pointer p-2 hover:bg-red-200 hover:text-red-500'>
              <q-icon name="logout" class="text-[16px] font-bold mr-3"/>
              <p>Logout</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<q-dialog v-model="OpenLogout">
  <q-card class="w-[500px]">
    <q-card-section class="gap-3 items-center q-pb-none flex">
      <div class="py-1 px-2 border text-[24px]"><q-icon name="logout"/></div>
      <div class="text-h6 font-bold">Logout</div>
      <q-space />
    </q-card-section>

    <q-card-section>

      <p>Are you sure you want to Logout?</p>
    </q-card-section>

    <q-card-actions class="flex justify-center items-center">
      <div class="w-1/2 p-1">
        <q-btn flat label="Cancel" outline v-close-popup class="w-full border"/>
      </div>
      <div class="w-1/2 p-1">
        <q-btn
          @click="logout"
          flat
          label="Logout"
          size="md"
          class="bg-red-600 text-white rounded w-full "
        />
      </div>
    </q-card-actions>
  </q-card>
</q-dialog>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';

export default {
  setup() {
    const $q = useQuasar();
  },
  data() {
    return {
      isAdmin: 0,
      email: '',
      fullname: '',
      firstname: '',
      middlename: '',
      lastname: '',
      userProfileImage: null,
      username: '',
      position: '',
      status: '',
      drawer: false,
      showMenuIcon: false,
      statusCheckTimer: null,
      toggleDrawers: true,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      OpenLogout: false,
      modalVisible: false,
    };
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  mounted() {
    this.loadUserData();
  },
  methods: {
    logout() {
      sessionStorage.clear();
      this.$router.push('/');
    },
    loadUserData() {
      const userData = SessionStorage.getItem('information');

      if (userData) {
        try {
          const userInformation = JSON.parse(userData);
          this.fullname = this.firstname + " " + this.lastname;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
        } catch (error) {
          console.log('Error parsing user data:', error);
          // Provide user feedback or navigate to an error page
          this.$q.notify({
            type: 'negative',
            message: 'Error loading user data. Please try again.',
          });
          this.$router.push('/');
          sessionStorage.clear();
        }
      } else {
        // Handle the case when user data is not available
        this.$router.push('/');
        sessionStorage.clear();
      }
    },
    toggleModals() {
      this.modalVisible = !this.modalVisible;
    },
    toggleProduction(){
      this.productionVisible = !this.productionVisible;
    },
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
    },
    getLimitedFullname(fullname, maxLength) {
      if (fullname.length > maxLength) {
        return fullname.substring(0, maxLength) + '...';
      }
      return fullname;
    },
    getUserProfileImagePath() {
      // Ensure userProfileImage is not null before creating the path
      if (this.userProfileImage) {
        return `/pfp/${this.userProfileImage}`;
      } else {
        // Return a default path or handle it as per your requirement
        return '/default_profile.png';
      }
    },
    toggleDrawer() {
      if (!this.toggleDrawers) {
        this.drawer = true;
        this.drawerWidth = 300;
        this.drawerIcon = 'arrow_forward_ios';
        this.toggleDrawers = true;
      } else {
        this.drawer = true;
        this.drawerWidth = 80;
        this.toggleDrawers = false;
        this.drawerIcon = 'arrow_back_ios_new';
      }
    },
  },
};
</script>
