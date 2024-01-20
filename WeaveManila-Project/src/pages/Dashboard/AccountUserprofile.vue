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


    <div class="modal fixed w-full h-full top-0 left-0 flex items-center  z-50  justify-center" v-show="showSuccessModal">
      <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" @click="closeModal"></div>
      <div class="modal-container bg-white w-[400px] h-[230px] md:max-w-md mx-auto rounded shadow-lg  z-50  overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
          <div class="modal-header flex text-right items-end justify-end">
            <slot name="header">
              <q-icon name="close" class="text-[20px]" @click="closeModal"/>
            </slot>
          </div>
          <div class="modal-body flex justify-center">
            <slot name="body" class="flex">
              <q-icon name="task_alt" class="text-[72px] text-[#9E896A]" />
              <div class="w-full text-center">
                <p class="text-[20px] font-bold">Personal Information Updated!</p>
              </div>
              <div class="w-full text-center">
                <p class="text-[14px]">Your personal information has been changed successfully.</p>
              </div>
            </slot>
          </div>
        </div>
      </div>
    </div>
    <router-link to="/dashboard/account-settings">
      <p class="text-[15px]"><q-icon name="arrow_back_ios"/> <span class=" font-bold text-[#9e896a]">Basic Info</span></p>
    </router-link>
        <div class="w-[800px] h-[430px] mt-2 border border-[#dfc8c0] rounded p-5 text-[15px]">
            <div class="flex justify-center">
              <div>
                <div class="flex justify-center">
                  <q-img
                  :src="getUserProfileImagePath()"
                  alt="Description of the image"
                  class="w-[100px] rounded-full"
                  />
                </div>
                <div class="flex gap-2 mt-3">
                  <q-btn dense label="Upload Photo" type="submit" class="bg-[#9e896a] rounded-full  text-white"/>
                  <q-btn label="Cancel" type="submit" class="bg-white rounded-full  text-[#9e896a] border border-[#9e896a]"/>
                </div>
              </div>
            </div>
            <q-form @submit="onSubmit">
            <div>
              <!-- Avatar options -->
              <p class="font-bold text-[24px]">Choose Avatar</p>
              <div class="grid grid-cols-5 mt-3 gap-4">
                <q-img
                  src="/pfp/default_pfp.png"
                  alt="Default Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('default_pfp')"
                  :class="{ 'selected-avatar': selectedAvatar === 'default_pfp' }"
                />
                <q-img
                  src="/pfp/man.png"
                  alt="Man Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('man')"
                  :class="{ 'selected-avatar': selectedAvatar === 'man' }"
                />
                <q-img
                  src="/pfp/man_2.png"
                  alt="Woman Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('man_2')"
                  :class="{ 'selected-avatar': selectedAvatar === 'man_2' }"
                />
                <q-img
                  src="/pfp/man_3.png"
                  alt="Woman Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('man_3')"
                  :class="{ 'selected-avatar': selectedAvatar === 'man_3' }"
                />
                <q-img
                  src="/pfp/man_4.png"
                  alt="Woman Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('man_4')"
                  :class="{ 'selected-avatar': selectedAvatar === 'man_4' }"
                />
                <q-img
                  src="/pfp/woman_1.png"
                  alt="Woman Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('woman_1')"
                  :class="{ 'selected-avatar': selectedAvatar === 'woman_1' }"
                />
                <q-img
                  src="/pfp/woman_2.png"
                  alt="Woman Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('woman_2')"
                  :class="{ 'selected-avatar': selectedAvatar === 'woman_2' }"
                />
                <q-img
                  src="/pfp/woman_3.png"
                  alt="Woman Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('woman_3')"
                  :class="{ 'selected-avatar': selectedAvatar === 'woman_3' }"
                />
                <q-img
                  src="/pfp/woman_4.png"
                  alt="Woman Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('woman_4')"
                  :class="{ 'selected-avatar': selectedAvatar === 'woman_4' }"
                />
                <q-img
                  src="/pfp/woman_5.png"
                  alt="Woman Avatar"
                  class="w-16 h-16 rounded-full"
                  @click="selectAvatar('woman_5')"
                  :class="{ 'selected-avatar': selectedAvatar === 'woman_5' }"
                />
              </div>
            </div>
            <div class="flex justify-end w-full gap-2 mt-3">
              <router-link
                to="/dashboard/account-settings"
                class="bg-white rounded-full text-center p-2 text-[#9e896a] w-[74px] border-2 border-[#9e896a]"
              >
                Cancel
              </router-link>
              <q-btn label="Save" type="submit" class="bg-[#9e896a] rounded-full text-white" />
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
        username: '',
        firstname: '',
        selectedAvatar: null,
        showModal: false,
        arrowDirection: false,
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
            this.userProfileImage = userInformation.pfp;
            this.firstname = userInformation.firstname;
            this.email = userInformation.email;
            this.uid = userInformation.uid;
          } catch (error) {
            console.log('Error parsing user data:', error);
            this.$router.push('/');
          }
        } else {
          // Handle the case when user data is not available
          this.$router.push('/');
        }
      },

      getUserProfileImagePath() {
        if (this.userProfileImage) {
          return `/pfp/${this.userProfileImage}.png`;
        } else {
          return '/default_profile.png';
        }
      },
      toggleModal() {
        this.arrowDirection = !this.arrowDirection;
        this.showModal = !this.showModal;
      },
      selectAvatar(avatar) {
        this.selectedAvatar = avatar;
      },

      onSubmit() {
        if (!this.selectedAvatar) {
          this.$q.notify({
            message: 'Please choose an avatar.',
            color: 'red',
          });
          return;
        }
        const formData = {
          pfp: this.selectedAvatar,
        };
        axios.put(`http://localhost/Capstone-Project/backend/api/Account_Settings/changeprofile.php/${this.uid}`, formData)
        .then((response) =>{
          this.responseStatus = response.data.status;
          this.responseMessage = response.data.message;
          this.responseInformation = response.data.information;
          if (this.responseStatus === "success") {
              const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
              existingInformation.pfp = this.responseInformation.pfp;
              SessionStorage.set('information', JSON.stringify(existingInformation));
              this.$q.notify({
                message: 'Successfully changed profile picture.',
                color: 'green',
              });
              this.loadUserData();
              this.$router.push('/dashboard/account-profilepic');
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

<style scoped>
.selected-avatar {
  border: 2px solid #00f; /* Add your desired border style/color */
}
</style>
