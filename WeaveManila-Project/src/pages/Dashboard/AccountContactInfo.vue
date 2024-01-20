<template>
<q-header elevated class="bg-white w-full text-black h-[100px]  md:flex md:justify-between border-2">
  <div class="md:w-[400px] p-4 md:flex min-[320px]:hidden">
      <div>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        <q-img
          src="../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[60px] md:w-[60px] "
        />
      </div>
      <div class="w-[250px]">
        <p class="text-[20px] text-[#8F8073] font-bold ">WEAVEMANILA INC.</p>
        <p class="text-[12px] text-[#9e896a]">Production Monitoring & Inventory Management System</p>
      </div>
  </div>
  <div class="flex items-center p-4 gap-2 min-[320px]:justify-between">
    <q-btn flat @click="drawer = !drawer" round dense icon="menu" class="md:hidden"/>
    <div class="flex items-center p-4 gap-2">
    <q-icon name="notifications" class="text-[21px]"/>
    <div>
        <q-img
          :src="getUserProfileImagePath()"
          alt="Description of the image"
          class="w-12 md:w-12 rounded-full border-black border"
        />
        </div>
        <div>
          {{ firstname }}
        </div>
        <q-icon
          :name="arrowDirection ? 'arrow_drop_up' : 'arrow_drop_down'"
          class="text-[25px] cursor-pointer"
          @click="toggleModal"
        />
      </div>
    <div v-if="showModal" class="fixed right-5 top-[110px] transform bg-white p-3 border border-gray-300 z-50 rounded-md drop-shadow-lg w-[308px] h-[200px]">
      <div class="flex justify-center">
        <div>
          <div class="flex justify-center mt-3 ">
            <q-img
              :src="getUserProfileImagePath()"
              alt="Description of the image"
              class="w-[80px] rounded-full border-black border"
            />
          </div>
          <div class="font-bold">{{ firstname }} {{ lastname }}</div>
          <div class="text-center">{{ position }}</div>
        </div>
      </div>
      <router-link to="/dashboard/account-settings">
        <p class="flex justify-between text-[16px]">
          Account Settings <q-icon name="manage_accounts" class="mr-2 text-[16px]"/>
        </p>
      </router-link>
      <router-link @click="logout" to="/">
        <p class="flex justify-between text-[16px]">
          Logout <q-icon name="logout" class="mr-2 text-[16px]"/>
        </p>
      </router-link>
    </div>
  </div>
</q-header>
  <q-drawer show-if-above v-model="drawer" side="left" bordered>
    <ul class="p-4">
      <li class="font-bold">Overview</li>
        <li class="py-[17px] px-[20px]">
          <div class="flex items-center">
            <router-link to="/dashboard/main-dashboard">
            <q-icon name="dashboard" class="mr-2"/> Dashboard
            </router-link>
          </div>
        </li>
        <!-- Process Section -->
        <li class="font-bold">Process</li>
        <li class="py-[17px] px-[20px]">
          <div class="flex items-center gap-2">
            <q-icon name="inventory"/> Inventory
          </div>
        </li>
        <li class="py-[17px] px-[20px] ">
          <div class="flex items-center gap-2">
            <q-icon name=""/> Product Monitoring
          </div>
        </li>
        <li class="py-[17px] px-[20px]">
          <div class="flex items-center">
            <q-icon name="description" class="mr-2"/> Production Cost Report
          </div>
        </li>
        <!-- Settings Section -->
        <li class="font-bold">Settings</li>
        <li class="py-[17px] px-[20px]">
          <div class="flex items-center">
            <q-icon name="" class="mr-2"/> Audit Logs
          </div>
        </li>
        <li class="py-[17px] px-[20px]">
          <div class="flex items-center">
            <q-icon name="group" class="mr-2"/> User Management
          </div>
        </li>
    </ul>
  </q-drawer>
  <q-page class="bg-[#f5f5f5] p-4">
    <div class="bg-white h-[520px] rounded p-10 overflow-auto">
      <router-link to="/dashboard/account-settings">
        <p class="text-[15px]"><q-icon name="arrow_back_ios"/> <span class=" font-bold text-[#9e896a]">Basic Info</span></p>
      </router-link>
      <div class="w-[500px] h-[320px] mt-2 border border-[#dfc8c0] rounded p-5 text-[15px]">
          <q-form @submit="onSubmit">
            <p class="text-[#9e896a] font-bold">Email</p>
            <q-input v-model="email" label="Email" outlined  dense class="custom-border-color mt-3" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            <p class="text-[#9e896a] font-bold">Phone</p>
              <q-input
                v-model="mobilenumber"
                label="Phone Number"
                type="number"
                outlined
                dense
                class="custom-border-color mt-3"
                lazy-rules
                :maxlength="12"
                :rules="[val => val && val.length > 0 || 'Please type something', val => val && val.length <= 12 || 'Maximum length is 12 characters']"
              />
              <div class="flex justify-end w-full gap-2">
              <router-link to="/dashboard/account-settings" class="bg-white rounded-full text-center p-2 text-[#9e896a] w-[74px] border-2 border-[#9e896a]">
                Cancel
              </router-link>
              <q-btn label="Save" type="submit" class="bg-[#9e896a] rounded-full  text-white"/>
            </div>
          </q-form>
      </div>
    </div>
  </q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';

export default {
  setup() {
      const $q = useQuasar();

      return { $q };
  },
  data() {
    return {
      responseInformation: '',
      responseStatus: '',
      uid: '',
      email: '',
      userProfileImage: null,
      mobilenumber: '',
      arrowDirection: false,
      showModal: false,
      drawer: true,
    };
  },

  mounted() {
    this.loadUserData();
  },
  methods: {
    loadUserData() {
      const userData = SessionStorage.getItem('information');
      console.log(userData);
      if (userData) {
        try {
          const userInformation = JSON.parse(userData);
          this.email = userInformation.email;
          this.uid = userInformation.uid;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;

          this.mobilenumber = userInformation.mobilenumber;

        } catch (error) {
          console.log('Error parsing user data:', error);
          // Provide user feedback or navigate to an error page
          this.$q.notify({
            type: 'negative',
            message: 'Error loading user data. Please try again.',
          });
          this.$router.push('/');
        }
      } else {
        // Handle the case when user data is not available
        this.$router.push('/');
      }
    },
    getUserProfileImagePath() {
      // Ensure userProfileImage is not null before creating the path
      if (this.userProfileImage) {
        return `/pfp/${this.userProfileImage}.png`;
      } else {
        // Return a default path or handle it as per your requirement
        return '/default_profile.png';
      }
    },
    toggleModal() {
      this.arrowDirection = !this.arrowDirection;
      this.showModal = !this.showModal;
    },

    onSubmit() {
      const formData = {
        Email: this.email,
        CPnumber: this.mobilenumber,
      };
      console.log(formData);
      axios.put(`http://localhost/Capstone-Project/backend/api/Account_Settings/contactinfo.php/${this.uid}`, formData)
      .then((response) =>{
        this.responseStatus = response.data.status;
        this.responseInformation = response.data.information;
        console.log(this.responseInformation);
        if (this.responseStatus === "success") {
            const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
            existingInformation.email = this.responseInformation.email;
            existingInformation.mobilenumber = this.responseInformation.mobilenumber;
            this.$q.notify({
                message: 'Contact Information Updated!',
                caption: 'Your contact iformation has been changed successfully.',
                color: 'green',
            });

            SessionStorage.set('information', JSON.stringify(existingInformation));
            this.loadUserData();
            this.$router.push('/dashboard/account-contactinfo');

        }
      }).catch(error => {
        console.error('Error submitting form:', error);
      });
    },
    closeModal() {
      this.showSuccessModal = false;
    },
    logout() {
      sessionStorage.clear();
      this.$router.push('/');
    },
  },
};
</script>
