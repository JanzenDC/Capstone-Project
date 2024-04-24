<template>
<SideBar/>
<q-page class="bg-[#f5f5f5]">
  <div class='flex justify-between items-center text-[30px] bg-white p-2'>
    <div class="items-center flex">
      <q-icon
        name="menu"
        v-if="showMenuIcon"
        @click="toggleDrawer"
        class="cursor-pointer"
      />
      <q-icon
        name="menu"
        v-if="!showMenuIcon"
        @click="toggleDrawer"
        class="cursor-pointer max-[1020px]:flex min-[1020px]:hidden"
      />
      <div>
        <span class="font-bold">Account Settings</span>
        <div class="text-[16px] text-[#999999]">
          <p class="text-[16px] text-[#755e4a]">Setup your account, edit profile details</p>
        </div>
      </div>
    </div>
    <LogoutTop />
  </div>

  <div class="p-4 ">
    <div class="flex mt-8">
      <router-link to="account-settings">
        <div class="flex bg-white border-e-2 w-[128px] h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px] ">
          <q-icon name="list"/>
          <p>Profile</p>
        </div>
      </router-link>
    </div>

    <div class="w-full bg-white p-4 overflow-x-hidden overflow-y-auto h-[430px]">
      <div class='flex gap-3 items-center border-orange-100 border-2 rounded drop-shadow-md p-4'>
        <q-img
        :src="getUserProfileImagePath()"
        alt="Description of the image"
        class="w-[80px] h-[80px] rounded-full"
        />
        <div>
          <p class='font-bold text-[24px]'>Profile Picture</p>
          <q-btn dense icon='upload' label="Upload Photo" @click="uploadDialog = true" class="bg-[#634832] text-white mt-3"/>
          <p class='mt-3'>We support PNGs</p>
            <q-dialog v-model="uploadDialog" persistent transition-show="scale" transition-hide="scale">

              <q-card class="text-Black" style="width: 350px">
                <q-form @submit="onUpload">
                  <q-card-section class="row items-center q-pb-none">
                    <div class="text-h6">Update Profile</div>
                    <q-space />
                    <q-btn icon="close" flat round dense v-close-popup />
                  </q-card-section>

                  <q-separator />
                  <q-card-section>
                    <div class="flex justify-center">
                      <q-img
                        :src="previewImage || getUserImagePath()"
                        alt="Description of the image"
                        class="w-[200px] h-[200px] rounded-full mt-3"
                      />
                    </div>
                    <div class='flex justify-center mt-3'>
                      <q-input
                        ref="fileInput"
                        @update:model-value="handleFileChange"
                        dense outlined
                        type="file"
                        accept="image/png"
                        hint="Only PNG format picture allowed."
                        v-model="selectedFile"
                        class='w-[240px]'
                      />
                      <div v-if="previewImage">
                        <q-btn flat label="Cancel Preview" @click="cancelPreview" class="q-mt-sm" />
                      </div>
                    </div>
                  </q-card-section>


                <q-separator />

                <q-card-actions align="right" class="bg-white text-teal">
                  <q-btn flat label="Close" @click="cancelUpload" class='text-black' v-close-popup />
                  <q-btn label="Save" type="submit" class="bg-[#9e896a] rounded-md text-white"/>
                </q-card-actions>

                </q-form>
              </q-card>
            </q-dialog>
        </div>
      </div>
      <div class='items-center border-orange-100 border-2 rounded drop-shadow-md p-4 mt-3'>
        <q-form @submit="OnUpdateUser">
          <!-- Basic Information -->
          <div>
          <div class='text-[16px] font-bold'>Basic Information</div>
          <div class='grid grid-cols-4 gap-3 mt-4'>
            <div>
              <p>First Name</p>
              <q-input v-model="fname"  outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            </div>
            <div>
              <p>Middle Name</p>
              <q-input v-model="mname"  outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            </div>
            <div>
              <p>Last Name</p>
              <q-input v-model="lname"  outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            </div>
            <div>
              <p>Suffix Name</p>
              <q-input v-model="sname"  outlined  dense class="custom-border-color"/>
            </div>
            <div>
              <p>Birthday</p>
              <q-input v-model="bdate" type='date' outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            </div>
            <div>
              <p>Gender</p>
              <q-select v-model="vgender" :options='genderOptions' outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            </div>
            <div>
              <p>Status</p>
              <q-select v-model="civStatus" :options='statusOptions' outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
            </div>
            <div>
              <p>Email</p>
              <q-input v-model="vemail" outlined  dense class="custom-border-color" lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
          </div>
          </div>
          </div>

          <!-- Address -->
          <div>
            <div class='text-[16px] font-bold'>Address</div>
              <q-input v-model='addressValue' dense outlined disable class='mt-4'>
                <template v-slot:before>
                  <q-icon name="edit" class='cursor-pointer' @click='toggleEditAddress'/>
                </template>
              </q-input>
              <div class="grid grid-cols-3 gap-3 mt-3" v-if='showAddressEdit'>
                <div>
                  <p>Region<span class="text-red-600">*</span></p>
                  <q-select v-model="selectedRegion" :options="regionOptions" label="Region" @input="onRegionChange" dense outlined class='flex-wrap' />
                </div>
                <div>
                  <p>Province<span class="text-red-600">*</span></p>
                  <q-select
                    v-model="selectedProvince"
                    :options="provinceOptions"
                    label="Province"
                    dense outlined
                    :disable="!selectedRegion"
                  >
                  </q-select>
                </div>
                <div>
                  <p>City<span class="text-red-600">*</span></p>
                  <q-select v-model="selectedCity" :options="cityOptions" label="City" dense outlined :disable="!selectedProvince" class='flex-wrap'/>
                </div>
                <div>
                  <p>Barangay<span class="text-red-600">*</span></p>
                  <q-select v-model="selectedBarangay" :options="barangayOptions" label="Barangay" dense outlined :disable="!selectedCity" />
                </div>
                <div>
                  <p>
                    Unit no./House no. /Building Name
                  </p>
                  <q-input type="text" label="Unit no./House no. /Building Name" v-model="suppUnit" lazy-rules :no-error-icon="true" outlined dense />
                </div>
                <div>
                  <p>
                    Street
                  </p>
                  <q-input type="text" label="Street" v-model="suppStreet"  lazy-rules :no-error-icon="true" outlined dense />
                </div>
                <div>
                  <p>
                    Zip Code
                  </p>
                  <q-input type="text" label="Zip Code" v-model="suppZipcode"  lazy-rules :no-error-icon="true" outlined dense />
                </div>
              </div>
          </div>

          <div class='flex justify-end items-end mt-5'>
            <q-btn label='Save Changes' type='submit' class='bg-[#634832] text-white' />
          </div>
        </q-form>
      </div>
      <div class='items-center border-orange-100 border-2 rounded drop-shadow-md p-4 mt-3'>
        <div class='text-[16px] font-bold'>Change Password</div>
        <q-form @submit='ChangePassword' class='mt-4'>
          <div class='flex gap-5'>
            <div>
              <p>Current Password</p>
              <q-input
                :type="showPassword ? 'text' : 'password'"
                label="Current Password"
                outlined
                dense
                v-model="currentPW"
                class="w-[205px]"
                :no-error-icon="true"
              >
              </q-input>
            </div>
            <div>
              <p>New Password</p>
                <q-input
                  :type="showChangePassword ? 'text' : 'password'"
                  label="Change Password"
                  outlined
                  dense
                  v-model="changePW"
                  class="w-[205px]"
                  :no-error-icon="true"
                >
                </q-input>
            </div>
            <div>
              <p>Confirm Password</p>
                <q-input
                  :type="showChangePassword ? 'text' : 'password'"
                  label="Confirm Password"
                  outlined
                  dense
                  v-model="confirmPW"
                  class="w-[250px]"
                  :no-error-icon="true"
                >
                </q-input>
            </div>
          </div>

          <div v-if="!allRulesMet" class='mt-3'>
            <p class="font-bold text-[16px]">Password Rules:</p>
            <p v-if="showLengthRule" class="mt-2">● Your password must be at least 10 characters long.</p>
            <p v-if="showUpperLowerSpecialRule" class="mt-2">● Include upper and lowercase letters and special characters, such as !, @, #, $, etc.</p>
            <p v-if="showNumberRule" class="mt-2">● Use at least one numerical digit.</p>
            <p v-if="showPreviousPasswordRule" class="mt-2">● Cannot be the same as the previous password.</p>
          </div>
          <div class='flex justify-end items-end'>
            <q-btn label='Save Changes' type='submit' class='bg-[#634832] text-white' />
          </div>
        </q-form>
 
      </div>

      <div v-if='isAdmin == 1' class='items-center border-orange-100 border-2 rounded drop-shadow-md p-4 mt-3'>
        <div class='text-[16px] font-bold mb-4'>Company Logo</div>
        <p>Upload Logo</p>
        <div class="flex items-center gap-2 mt-3 ">
          <q-input v-model="companyLogo" outlined dense disable />
          <q-btn @click="triggerFileInput('prepared')" class="text-white bg-[#634832]">Change Photo</q-btn>
          <input ref="preparedInput" type="file" style="display: none" @change="handleFileChanges('prepared', $event)">
        </div>
        <div class='flex justify-end items-end'>
          <q-btn label='Save Changes' @click="UploadCompanyLogo" class='bg-[#634832] text-white' />
        </div>
      </div>
    </div>
  </div>
</q-page>

</template>

<script>
// import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import SideBar from '../Essentials/SideBar.vue';
import LogoutTop from '../Essentials/LogoutTop.vue';
import philippineData from '../../../../javascript/philippine_provinces_cities_municipalities_and_barangays_2019v2.json';
export default {
  components: {
    SideBar,
    LogoutTop
  },
  data() {
    return {
      isAdmin: 0,
      id: '',
      email: '',
      userProfileImage: null,
      username: '',
      firstname: '',
      middlename: '',
      lastname: '',
      gender: '',
      birthdate: '',
      address: '',
      position: '',
      mobilenumber: '',
      password: '',
      status: '',
      arrowDirection: false,
      showModal: false,
      fullname: '',
      toggleDrawers: true,
      drawer: false,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      statusCheckTimer: null,
      showMenuIcon: false,
      OpenLogout: false,
      modalVisible: false,

      fname: '',
      mname: '',
      lname: '',
      sname: '',
      bdate: '',
      vgender: '',
      civStatus: '',
      vemail: '',
      selectedAvatar: null,
      uploadDialog: false,
      file: null,
      previewImage: null,
      selectedFile: null,
      genderOptions: ['Male', 'Female', 'Rather not to say'],
      statusOptions: ['Single', 'Married'],
      philippineData: philippineData,
      selectedRegion: null,
      selectedProvince: null,
      selectedCity: null,
      selectedBarangay: null,
      regionOptions: [],
      provinceOptions: [],
      cityOptions: [],
      barangayOptions: [],
      addressValue: '',
      showAddressEdit: false,
      suppUnit: '',
      suppStreet: '',
      suppZipcode: '',

      currentPW: '',
      changePW: '',
      confirmPW: '',
      showPassword: false,
      showChangePassword: false,
      showLengthRule: true,
      showUpperLowerSpecialRule: true,
      showNumberRule: true,
      showPreviousPasswordRule: true,
      companyLogo: '',
      companyLogos: '',
    };
  },
  computed: {
    allRulesMet() {
      return !this.showLengthRule && !this.showUpperLowerSpecialRule && !this.showNumberRule && !this.showPreviousPasswordRule;
    }
  },
  mounted() {
    this.regionOptions = Object.keys(this.philippineData)
    .map(regionCode => ({
      label: /^(0[1-9]|1[0-3]|[4][A-B]|[1-3]?[0-9])$/.test(regionCode) ? `Region ${regionCode}` : regionCode,
      value: regionCode
    }))
    .sort((a, b) => a.label.localeCompare(b.label));
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
    this.checkUserStatus();
    }, 1 * 1000); // 5 minutes (in milliseconds)
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  watch: {
    changePW: function(newVal) {
      this.showLengthRule = newVal.length < 10;
      this.showUpperLowerSpecialRule = !(/[a-z]/.test(newVal) && /[A-Z]/.test(newVal) && /[!@#$%^&*(),.?":{}|<>]/.test(newVal));
      this.showNumberRule = !/\d/.test(newVal);
      this.showPreviousPasswordRule = this.currentPW === this.changePW;
    },
    file: 'handleFileChange',
    suppUnit: 'updateSuppAddress',
    suppStreet: 'updateSuppAddress',
    suppZipcode: 'updateSuppAddress',
    selectedRegion: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onRegionChange();
      }
    },
    selectedProvince: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onProvinceChange();
      }
    },
    selectedCity: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onCityChange();
      }
    },
    selectedBarangay: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onBaranggayChange();
      }
    }
  },
  methods: {
    UploadCompanyLogo() {
      console.log(this.companyLogo);
      console.log(this.companyLogos);
      const formData = new FormData();
      formData.append('file', this.companyLogos);
      formData.append('id', this.id);
      axios.post(`http://localhost/Capstone-Project/backend/api/Account_Settings/changelogo.php/`, formData)
      .then((response) =>{
        this.responseStatus = response.data.status;
        this.responseInformation = response.data.information;
        if (this.responseStatus === "success") {
            this.$q.notify({
                message: 'Company Logo Updated!!',
                color: 'green',
            });
            this.loadUserData();
        }
        if (this.responseStatus === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${response.data.message} Please try again.`,
          });
        }
      }).catch(error => {
        console.error('Error submitting form:', error);
      });

    },
    triggerFileInput(type) {
      this.$refs[`${type}Input`].click();
    },
    handleFileChanges(type, event) {
      const file = event.target.files[0];
      if (file) {
        // Save the uploaded file reference based on type
        switch (type) {
          case 'prepared':
            this.companyLogos = file;
            this.companyLogo = file.name;
            break;
            this.s_esignatureA = file;
            this.s_uploadApproveName = file.name;
            break;
        }
        console.log("Uploaded file:", file);
      }
    },
    ChangePassword(){
      const formData = {
        currentPass: this.currentPW,
        newpass: this.changePW,
      }
      axios.put(`http://localhost/Capstone-Project/backend/api/Account_Settings/changepassword.php/${this.id}`, formData)
      .then((response) =>{
        this.responseStatus = response.data.status;
        this.responseInformation = response.data.information;
        if (this.responseStatus === "success") {
            const existingInformation = JSON.parse(SessionStorage.getItem('information')) || {};
            existingInformation.password = this.responseInformation.password;
            this.$q.notify({
                message: 'Password Updated!!',
                caption: 'Your password has been changed successfully.',
                color: 'green',
            });
            this.currentPW = '';
            this.changePW = null;
            this.confirmPW = null;
            SessionStorage.set('information', JSON.stringify(existingInformation));
            this.loadUserData();
        }
        if (this.responseStatus === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${response.data.message} Please try again.`,
          });
        }
      }).catch(error => {
        console.error('Error submitting form:', error);
      });
    },
    OnUpdateUser() {
      console.log('Clicked')
      this.$q.loading.show({
        message: 'Updating user profile  is in progress. Hang on...'
      });
      const formData = {
        Firstname: this.fname,
        Middlename: this.mname,
        Lastname: this.lname,
        Suffix: this.sname,
        Birthdate: this.bdate,
        Gender: this.vgender,
        CivilStatus: this.civStatus,
        Email: this.vemail,
        Address: this.addressValue
      };
      console.log(formData)
      axios.put(`http://localhost/Capstone-Project/backend/api/Account_Settings/basicinfo.php/${this.email}`, formData)
      .then((response) =>{
        console.log(response.data)
        this.responseStatus = response.data.status;
        this.responseInformation = response.data.information;
        if (this.responseStatus === "success") {

            setTimeout(() => {
              this.$q.notify({
                  message: 'Personal Information Updated!',
                  caption: 'Your personal information has been changed successfully.',
                  color: 'green',
              });
              this.loadUserData();
              this.$q.loading.hide(); // Hide the loading spinner
            }, 3000);
            setTimeout(() => {
              window.location.reload(); // Reload the window after 3 seconds
            }, 3500);
        }
        if (this.responseStatus === "fail") {
          this.$q.notify({
                caption: 'Failed to update.',
                color: 'negative',
          });
          this.loadUserData();
          setTimeout(() => {
            window.location.reload(); // Reload the window after 3 seconds
            this.$q.loading.hide(); // Hide the loading spinner
          }, 3000);
        }
      }).catch(error => {
        console.error('Error submitting form:', error);
      });
    },
    onRegionChange() {
    //   console.log(this.selectedRegion.value);
    //   console.log(philippineData[this.selectedRegion.value]);
    //  // Access the province list for the selected region
      this.selectedProvince = null;
      this.selectedCity = null;
      this.selectedBarangay = null;
      const regionData = this.philippineData[this.selectedRegion.value].province_list;

      // Map the province names to options format
      this.provinceOptions = Object.keys(regionData).map(provinceName => ({
        label: provinceName,
        value: provinceName
      }));
      this.updateSuppAddress();
    },
    onProvinceChange() {
      // Check if selectedProvince is not null before accessing its value
      if (this.selectedProvince !== null) {
        this.selectedCity = null;
        this.selectedBarangay = null;
        const selectedProvinceData = this.philippineData[this.selectedRegion.value].province_list[this.selectedProvince.value];
        if (selectedProvinceData) {
          const municipalityData = selectedProvinceData.municipality_list;
          console.log(municipalityData);

          this.cityOptions = Object.keys(municipalityData).map(municipalityName => ({
            label: municipalityName,
            value: municipalityName
          }));
          this.updateSuppAddress();
        }
      }
    },
    onCityChange() {
      if (this.selectedCity !== null) {
        this.selectedBarangay = null;
        const selectedMunicipalityData = this.philippineData[this.selectedRegion.value].province_list[this.selectedProvince.value].municipality_list[this.selectedCity.value];
        if (selectedMunicipalityData) {
          const barangayList = selectedMunicipalityData.barangay_list;
          console.log(barangayList);

          this.barangayOptions = barangayList.map(barangayName => ({
            label: barangayName,
            value: barangayName
          }));
          this.updateSuppAddress();
        }
      }
    },
    onBaranggayChange() {
      if (this.selectedBarangay !== null) {
        this.updateSuppAddress();
      }
    },
    updateSuppAddress() {
      let address = '';
      if (this.selectedRegion) address += `${this.selectedRegion.label}, `;
      if (this.selectedProvince) address += `${this.selectedProvince.label}, `;
      if (this.selectedCity) address += `${this.selectedCity.label}, `;
      if (this.selectedBarangay) address += `${this.selectedBarangay.label},`;
      if (this.suppUnit) address += `${this.suppUnit}, `;
      if (this.suppStreet) address += `${this.suppStreet}, `;
      if (this.suppZipcode) address += `${this.suppZipcode}, `;
      // Trim trailing comma and space
      this.addressValue = address.replace(/,\s*$/, '');
    },
    toggleEditAddress(){
      this.showAddressEdit = !this.showAddressEdit;
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

      axios.post(`http://localhost/Capstone-Project/backend/api/Account_Settings/uploadprofile.php`, formData)
      .then((response) => {
        console.log(response.data);
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
    toggleModals() {
      this.modalVisible = !this.modalVisible;
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
    checkUserStatus() {
        axios.get(`http://localhost/Capstone-Project/backend/api/verification.php?email=${this.email}`)
        .then(response => {

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
            isAdmin: information.isAdmin,
            suffix: information.suffix,
            civil_status: information.civil_status
          };
          SessionStorage.set('information', JSON.stringify(this.information));

          const latestAdmin = response.data.information.isAdmin;
          const latestStatus = response.data.information.status;

          if (this.status !== latestStatus || (latestAdmin && latestStatus === 0)) {
            this.status = latestStatus;

            if (this.status === 0 && !latestAdmin) {
              this.$q.notify({
                type: 'negative',
                message: 'Your account is currently inactive. Please contact the administrator.',
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
          console.log(userInformation)
          // Form Data
          this.addressValue = userInformation.address;
          this.fname = userInformation.firstname;
          this.mname = userInformation.middlename;
          this.lname = userInformation.lastname;
          this.sname = userInformation.suffix;
          this.bdate = userInformation.birthdate;
          this.vgender = userInformation.gender;
          this.vemail = userInformation.email;
          this.civStatus = userInformation.civil_status;
          //


          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;
          this.gender = userInformation.gender;
          this.birthdate = userInformation.birthdate;
          this.position = userInformation.position;
          this.mobilenumber = userInformation.mobilenumber;
          this.id = userInformation.id;
          this.password = userInformation.password ? '*'.repeat(Math.min(8, userInformation.password.length)) : '';
          this.address = userInformation.address;
          this.status = userInformation.status;
          this.id = userInformation.id;
          this.fullname = this.firstname + " " + this.lastname;
          this.isAdmin = userInformation.isAdmin;

          if (this.position.toLowerCase() === 'owner') {
          this.$router.push('/dashboard/account-settings');
          }else{
            this.$q.notify({
            type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }
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
    getLimitedFullname(fullname, maxLength) {
      if (fullname.length > maxLength) {
        return fullname.substring(0, maxLength) + '...';
      }
      return fullname;
    },
    toggleProduction(){
      this.productionVisible = !this.productionVisible;
    },
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
    },
    toggleModal() {
      this.arrowDirection = !this.arrowDirection;
      this.showModal = !this.showModal;
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
    logout() {
      sessionStorage.clear();
      this.$router.push('/');
    },
  },
};
</script>
