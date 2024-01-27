<template>
  <q-header elevated class="bg-white w-full text-black h-[100px]  md:flex md:justify-between border-2">
    <div class="md:w-[400px] p-4 md:flex min-[390px]:hidden">
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
    <div class="flex items-center p-4 gap-2 min-[390px]:justify-between">
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
  <q-drawer
  show-if-above
  v-model="drawer"
  side="left"
  bordered
  :width="250">
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
              <i class="bi bi-box-seam"></i> Product Monitoring
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
              <router-link to="/dashboard/auditlogs-section">
                <i class="bi bi-activity"></i> Audit Logs
              </router-link>
            </div>
          </li>
          <li class="py-[17px] px-[20px]">
            <div class="flex items-center">
              <router-link to="/dashboard/usermanagement-section">
                <q-icon name="group" class="mr-2"/> User Management
              </router-link>
            </div>
          </li>
      </ul>
  </q-drawer>
  <q-page class="bg-[#f5f5f5] p-4">
    <div class="bg-white h-[520px] rounded p-10 overflow-auto">

  <router-link to="/dashboard/account-settings">
    <p class="text-[15px]"><q-icon name="arrow_back_ios"/> <span class=" font-bold text-[#9e896a]">Basic Info</span></p>
  </router-link>
      <div class="md:w-[800px] md:h-[430px] mt-2 border border-[#dfc8c0] rounded p-5 text-[15px]">
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
                <q-btn dense label="Upload Photo" @click="uploadDialog = true" class="bg-[#9e896a] rounded-full  text-white"/>
                <q-dialog v-model="uploadDialog" persistent transition-show="scale" transition-hide="scale">

                  <q-card class="text-Black" style="width: 550px">
                    <q-form @submit="onUpload">
                      <q-card-section class="row items-center q-pb-none">
                        <div class="text-h6">Update Profile</div>
                        <q-space />
                        <q-btn icon="close" flat round dense v-close-popup />
                      </q-card-section>

                    <q-separator />
                        <div class="flex justify-center">
                          <q-img
                            :src="previewImage || getUserImagePath()"
                            alt="Description of the image"
                            class="w-[300px] rounded-full"
                          />
                        </div>
                        <q-input
                          ref="fileInput"
                          @update:model-value="handleFileChange"
                          filled
                          type="file"
                          accept="image/png"
                          hint="Only PNG format picture allowed."
                          v-model="selectedFile"
                        />
                        <div v-if="previewImage">
                          <q-btn flat label="Cancel Preview" @click="cancelPreview" class="q-mt-sm" />
                        </div>

                    <q-separator />

                    <q-card-actions align="right" class="bg-white text-teal">
                      <q-btn label="Save" type="submit" class="bg-[#9e896a] rounded-md text-white"/>
                      <q-btn flat label="Discard Changes" @click="cancelUpload" v-close-popup />
                    </q-card-actions>
                    </q-form>
                  </q-card>
                </q-dialog>

              </div>
            </div>
          </div>
          <q-form @submit="onSubmit">
          <div>
            <!-- Avatar options -->
            <p class="font-bold text-[24px]">Choose Avatar</p>
            <div class="grid min-[390px]:grid-cols-2 md:grid-cols-5 mt-3 md:gap-4 min-[390px]:gap-9">
              <q-img
                src="/pfp/default_pfp.png"
                alt="Default Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('default_pfp.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'default_pfp.png' }"
              />
              <q-img
                src="/pfp/man.png"
                alt="Man Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('man.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'man.png' }"
              />
              <q-img
                src="/pfp/man_2.png"
                alt="Woman Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('man_2.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'man_2.png' }"
              />
              <q-img
                src="/pfp/man_3.png"
                alt="Woman Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('man_3.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'man_3.png' }"
              />
              <q-img
                src="/pfp/man_4.png"
                alt="Woman Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('man_4.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'man_4.png' }"
              />
              <q-img
                src="/pfp/woman_1.png"
                alt="Woman Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('woman_1.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'woman_1.png' }"
              />
              <q-img
                src="/pfp/woman_2.png"
                alt="Woman Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('woman_2.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'woman_2.png' }"
              />
              <q-img
                src="/pfp/woman_3.png"
                alt="Woman Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('woman_3.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'woman_3.png' }"
              />
              <q-img
                src="/pfp/woman_4.png"
                alt="Woman Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('woman_4.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'woman_4.png' }"
              />
              <q-img
                src="/pfp/woman_5.png"
                alt="Woman Avatar"
                class="w-16 h-16 rounded-full"
                @click="selectAvatar('woman_5.png')"
                :class="{ 'selected-avatar': selectedAvatar === 'woman_5.png' }"
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
        changeImage: null,
        username: '',
        firstname: '',
        lastname: '',
        position: '',
        status: '',
        selectedAvatar: null,
        showModal: false,
        arrowDirection: false,
        uploadDialog: false,
        file: null,
        previewImage: null,
        drawer: false,
        selectedFile: null,
        statusCheckTimer: null,
      };
    },
    watch: {
      file: 'handleFileChange',
    },
    mounted() {
      this.loadUserData();
      this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
      }, 1 * 1000); // 5 minutes (in milliseconds)
    },
    beforeUnmount() {
      clearInterval(this.statusCheckTimer);
    },
    methods: {
      checkUserStatus() {
          axios.get(`http://localhost/Capstone-Project/backend/api/verification.php?email=${this.email}`)
          .then(response => {
          const latestStatus = response.data.information.status;

          // Update the local status and take appropriate action if it has changed
          if (this.status !== latestStatus) {
            this.status = latestStatus;

            if (this.status === 0) {
              this.$q.notify({
                type: 'negative',
                message: 'Your account is currently inactive. Please contact the account owner for activation.',
              });
              this.$router.push('/');
              sessionStorage.clear();
            }
          }
        }).catch(error => {
              console.error('Error fetching data:', error);
        });
      },
      loadUserData() {
        const userData = SessionStorage.getItem('information');
        if (userData) {
          try {
            const userInformation = JSON.parse(userData);
            this.userProfileImage = userInformation.pfp;
            this.firstname = userInformation.firstname;
            this.lastname = userInformation.lastname;
            this.position = userInformation.position;
            this.email = userInformation.email;
            this.uid = userInformation.id;
            this.changeImage = userInformation.pfp;
            this.status = userInformation.status;
            if(this.status == 0)
            {
              this.$q.notify({
              type: 'negative',
                message: 'Your account is currently inactive. Please contact the account owner for activation.',
              });
              this.$router.push('/');
              sessionStorage.clear();
            }
          } catch (error) {
            this.$router.push('/');
            sessionStorage.clear();
          }
        } else {
          // Handle the case when user data is not available
          this.$router.push('/');
          sessionStorage.clear();
        }
      },
      handleFileChange(event) {
        this.selectedFile = event[0];
        if (event && event[0]) {
          const file = event[0];
          this.file = event;
          this.previewImage = URL.createObjectURL(file); // Set previewImage for preview
        }
      },

      cancelPreview() {
        this.file = 0;
        this.previewImage = 0;
        this.userProfileImage = this.userProfileImage; // Set back to default value
        this.$refs.fileInput.$el.querySelector('input[type=file]').value = null; // Clear file input
      },
      cancelUpload() {
        this.file = 0;
        this.previewImage = 0;
        this.userProfileImage = this.userProfileImage; // Set back to default value
        this.$refs.fileInput.$el.querySelector('input[type=file]').value = null; // Clear file input
      },
      getUserImagePath() {
        if (this.userProfileImage) {
          // Check if the file extension is present
          const hasExtension = /\.\w+$/.test(this.userProfileImage);

          if (hasExtension) {
            return `/pfp/${this.userProfileImage}`;
          } else {
            return `/pfp/${this.userProfileImage}`;
          }
        } else {
          return '/default_profile.png';
        }
      },
      getUserProfileImagePath() {
        if (this.userProfileImage) {
          // Check if the file extension is present
          const hasExtension = /\.\w+$/.test(this.userProfileImage);

          if (hasExtension) {
            return `/pfp/${this.userProfileImage}`;
          } else {
            return `/pfp/${this.userProfileImage}`;
          }
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
            console.log(response.data);
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
      onUpload() {
        if (!this.file) {
          this.$q.notify({
            message: 'Image does not exist.',
            color: 'red',
          });
          return;
        }
        console.log('File type:', typeof this.selectedFile);
        const formData = new FormData();
        const id = this.uid;
        formData.append("file", this.selectedFile);
        formData.append("id", id);

        axios
        .post(`http://localhost/Capstone-Project/backend/api/Account_Settings/uploadprofile.php`, formData)
        .then((response) => {
          this.responseStatus = response.data.status;
          this.responseInformation = response.data.information;
          if (this.responseStatus === "success") {
            const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
            existingInformation.pfp = this.responseInformation.pfp;
            this.$q.notify({
                message: 'Success',
                caption: 'You have successfully change your profile picture.',
                color: 'green',
            });
            this.uploadDialog = false;
            SessionStorage.set('information', JSON.stringify(existingInformation));
            this.loadUserData();
            this.$router.push('/dashboard/account-profilepic');
          }
          if (this.responseStatus === "fail") {

            this.$q.notify({
              color: 'negative',
              message: `${response.data.message} Please try again.`,
            });
          }
        })
        .catch((error) => {
          console.error('Error submitting form:', error);
        });
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
