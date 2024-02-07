<template>
  <div class="md:w-full  md:h-[430px] mt-2 border border-[#dfc8c0] rounded p-5 text-[15px]">
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
        <div
          v-close-popup
          class="bg-white rounded-full text-center p-2 text-[#9e896a] w-[74px] border-2 border-[#9e896a]"
        >
          Cancel
        </div>
        <q-btn label="Save" type="submit" class="bg-[#9e896a] rounded-full text-white" />
      </div>
    </q-form>
  </div>
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
        id: '',
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

        fullnames: '',
        drawer: false,
        showMenuIcon: false,
        inventoryMenuVisible: false,
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
      }, 5 * 1000);
    },
    beforeUnmount() {
      clearInterval(this.statusCheckTimer);
    },
    methods: {
      checkUserStatus() {
          axios.get(`http://localhost/Capstone-Project/backend/api/verification.php?email=${this.email}`)
          .then(response => {
          const latestStatus = response.data.information.status;
          const information = response.data.information;
          this.information = {
            id: information.id,
            email: information.email,
            username: information.username,
            pfp: information.pfp,
            firstname: information.firstname,
            middlename: information.middlename,
            lastname: information.lastname,
            gender: information.gender,
            position: information.position,
            mobilenumber: information.mobilenumber,
            birthdate: information.birthdate,
            age: information.age,
            address: information.address,
            otp_code: information.otp_code,
            isOnline: information.isOnline,
            status: information.status,
            password: information.password,
          };
          SessionStorage.set('information', JSON.stringify(this.information));
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
      getLimitedFullname(fullname, maxLength) {
        if (fullname.length > maxLength) {
          return fullname.substring(0, maxLength) + '...';
        }
        return fullname;
      },
      toggleInventoryMenu() {
        this.inventoryMenuVisible = !this.inventoryMenuVisible;
      },
      toggleDrawer() {
        this.drawer = !this.drawer;
        this.showMenuIcon = !this.showMenuIcon;
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
            this.id = userInformation.id;
            this.changeImage = userInformation.pfp;
            this.status = userInformation.status;
            this.fullnames = this.firstname + " " + this.lastname;

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
        console.log(formData);
          axios.put(`http://localhost/Capstone-Project/backend/api/Account_Settings/changeprofile.php/${this.id}`, formData)
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
                window.location.reload();
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
        const formData = new FormData();
        const id = this.id;
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
            window.location.reload();
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
