=<template>
<SideBar/>
<q-page class="bg-[#f5f5f5] ">
  <div class="flex justify-between items-center p-2 bg-white">
    <div class="text-[30px]">
      <div class="items-center flex">
        <!-- First version of menu icon -->
        <q-icon
          name="menu"
          v-if="showMenuIcon"
          @click="toggleDrawer"
          class="cursor-pointer"
        />
        <!-- Second version of menu icon for smaller screens -->
        <q-icon
          name="menu"
          v-if="!showMenuIcon"
          @click="toggleDrawer"
          class="cursor-pointer max-[1020px]:flex min-[1020px]:hidden"
        />
        <span class="font-bold">User Management</span>
      </div>
      <div class="text-[16px]">This section managing accounts, updating and adding a user in the system </div>
    </div>
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
                  <div @click="OpenLogout = true" class='flex items-center p-2 hover:bg-red-200 hover:text-red-500'>
                    <q-icon name="logout" class="text-[16px] font-bold mr-3"/>
                    <p>Logout</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
    </div>
  </div>
  <div class='p-4'>
    <div class="flex md:items-end md:justify-end mt-8">
      <div class="flex items-center gap-5">
        <q-input v-model="search" outlined dense placeholder="Search" class="md:w-[400px]">
          <template v-slot:prepend>
            <q-icon name="search" />
          </template>
        </q-input>
        <q-btn @click="AddUser">
          <i class="bi bi-plus-lg"></i>
          Add User
        </q-btn>
      </div>
    </div>
    <!-- Modal -->
    <q-dialog v-model="addUserModal" >
      <q-card class="w-[600px]">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6 font-bold">Add user</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>
        <q-form @submit="onSubmit">
          <q-card-section class='overflow-x-hidden overflow-y-auto h-[450px]'>
            <div class="text-h6 font-bold text-[#667085]">Personal Information</div>
            <div class="grid grid-cols-2 gap-1">
              <!-- Firstname -->
              <div>
                <p class="text-[15px]">First Name</p>
                <q-input
                  v-model="fname"
                  label="First Name"
                  type="text"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'First Name is required']"
                ></q-input>
              </div>
              <!-- Lastname -->
              <div>
                <p class="text-[15px]">Last Name</p>
                <q-input
                  v-model="lname"
                  label="Last Name"
                  type="text"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Last Name is required']"
                ></q-input>
              </div>
              <!-- Birthdate -->
              <div>
                <p class="text-[15px]">Birthday</p>
                <q-input
                  v-model="bdate"
                  label="Birthday"
                  type="date"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Birthday is required', val => validateAge(val) || 'He/She must be 18 years or older to register']">
                </q-input>
              </div>
              <!-- Gender -->
              <div>
                Gender
                <q-select
                  outlined
                  dense
                  v-model="gInput"
                  :options="options"
                  label="Gender"
                  :rules="[val => !!val || 'Gender is required']"
                />
              </div>
              <!-- Civil Status -->
              <div>
                Civil Status
                <q-select
                  outlined
                  dense
                  v-model="cInput"
                  :options="civilOptions"
                  label="Select option for civil status"
                  :rules="[val => !!val || 'Civil Status is required']"
                />
              </div>
              <!-- Address -->
              <div>
                <p class="text-[15px]">Address</p>
                <q-input
                  v-model="avalue"
                  label="Address"
                  type="text"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Address is required']"
                ></q-input>
              </div>
              <!-- Position Status -->
              <div>
                Position
                <q-select
                  outlined
                  dense
                  v-model="posvalue"
                  :options="posOptions"
                  :rules="[val => !!val || 'Position value is empty']"
                />
              </div>
            </div>
            <div class="text-h6 font-bold text-[#667085]">Contact Information</div>
            <div class="grid grid-cols-2 gap-5">
              <!-- Email -->
              <div>
                <p class="text-[15px]">Email Address</p>
                <q-input
                  v-model="evalue"
                  label="Email Address"
                  type="email"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Email Address is required',
                            val => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) || 'Invalid Email Address']"
                ></q-input>
              </div>
              <!-- Contact/Phone -->
              <div>
                <p class="text-[15px]">Contact Number</p>
                <q-input
                  v-model="cvalue"
                  label="Contact Number"
                  type="tel"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Contact Number is required',
                          val => /^09\d{9}$/.test(val) || 'Invalid Philippine contact number']"
                  pattern="09[0-9]{9}"
                ></q-input>
              </div>
            </div>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn label="Submit" type="submit" class='text-white bg-[#967259]'/>
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>

    <q-separator class="mt-3 mb-3" />
    <div class="q-pa-md">
      <q-table
        :rows="filteredTableData"
        :columns="columns"
        class="my-sticky-header-table"
        :dense="$q.screen.lt.md"
        flat bordered
        :pagination="initialPagination"
        row-key="yourUniqueRowKey"
      >
      <!-- User Components -->
      <template v-slot:body-cell-user="props">
        <q-td :props="props"  >
          <div class="flex items-center gap-4">
            <q-img :src="getUserImagePublicPath(props.row.user.image)" :alt="props.row.user.name" class="w-[34px] rounded-full min-[390px]:hidden md:flex"/>
            <div class="min-[390px]:flex md:block min-[390px]:gap-2">
              <p class="font-bold">
              {{ props.row.user.name }}
              </p>
              {{ props.row.user.email }}
            </div>
          </div>

        </q-td>
      </template>
      <!-- Status Components -->
      <template v-slot:body-cell-statuss="props">
        <q-td :props="props">
          <q-toggle
            v-model="props.row.value"
            :color="props.row.value ? 'green' : 'red'"
            @click="toggleClicked(props.row.id, props.row.value)"
            keep-color
          />
        </q-td>
      </template>

      <!-- Action Components -->
      <template v-slot:body-cell-action="props">
      <q-td :props="props">
        <div class="flex text-[13px] items-center cursor-pointer"
          @click="openDropdown(props.row.id, props.row.user.name,   props.row.userInfo.firstname,
          props.row.userInfo.lastname,
          props.row.userInfo.birthday,
          props.row.userInfo.gender,
          props.row.userInfo.civil_status,
          props.row.userInfo.address,
          props.row.userInfo.email,
          props.row.userInfo.mobile_number,
          props.row.userInfo.password,
          props.row.userInfo.position)">
          <q-btn icon="edit_square"/>
        </div>
      </q-td>
      </template>

      </q-table>
    </div>

    <q-dialog v-model="showEditArea" persistent >
      <q-card class="w-[600px]">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6 font-bold">Edit user</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup @click="closeEditDialog"/>
        </q-card-section>
        <q-form @submit="onSubmitEdit">
          <q-card-section class='overflow-x-hidden overflow-y-auto h-[450px]'>
            <div class="text-h6 font-bold text-[#667085]">Personal Information</div>
            <div class="grid grid-cols-2 gap-1">
              <!-- Firstname -->
              <div>
                <p class="text-[15px]">First Name</p>
                <q-input
                  v-model="fname"
                  label="First Name"
                  type="text"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'First Name is required']"
                ></q-input>
              </div>
              <!-- Lastname -->
              <div>
                <p class="text-[15px]">Last Name</p>
                <q-input
                  v-model="lname"
                  label="Last Name"
                  type="text"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Last Name is required']"
                ></q-input>
              </div>
              <!-- Birthdate -->
              <div>
                <p class="text-[15px]">Birthday</p>
                <q-input
                  v-model="bdate"
                  label="Birthday"
                  type="date"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Birthday is required']"
                ></q-input>
              </div>
              <!-- Gender -->
              <div>
                Gender
                <q-select
                  outlined
                  dense
                  v-model="gInput"
                  :options="options"
                  label="Gender"
                  :rules="[val => !!val || 'Gender is required']"
                />
              </div>
              <!-- Civil Status -->
              <div>
                Civil Status
                <q-select
                  outlined
                  dense
                  v-model="cInput"
                  :options="civilOptions"
                  label="Select option for civil status"
                  :rules="[val => !!val || 'Civil Status is required']"
                />
              </div>
              <!-- Address -->
              <div>
                <p class="text-[15px]">Address</p>
                <q-input
                  v-model="avalue"
                  label="Address"
                  type="text"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Address is required']"
                ></q-input>
              </div>
                <!-- Position Status -->
                <div>
                  Position
                  <q-select
                    outlined
                    dense
                    v-model="posvalue"
                    :options="posOptions"
                    :rules="[val => !!val || 'Position value is empty']"
                  />
                </div>
            </div>
            <div class="text-h6 font-bold text-[#667085]">Contact Information</div>
            <div class="grid grid-cols-2 gap-5">
              <!-- Email -->
              <div>
                <p class="text-[15px]">Email Address</p>
                <q-input
                  v-model="evalue"
                  label="Email Address"
                  type="email"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Email Address is required',
                            val => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) || 'Invalid Email Address']"
                ></q-input>
              </div>
              <!-- Contact/Phone -->
              <div>
                <p class="text-[15px]">Contact Number</p>
                <q-input
                  v-model="cvalue"
                  label="Contact Number"
                  type="tel"
                  outlined
                  dense
                  :no-error-icon="true"
                  :rules="[val => !!val || 'Contact Number is required',
                          val => /^09\d{9}$/.test(val) || 'Invalid Philippine contact number']"
                  pattern="09[0-9]{9}"
                ></q-input>
              </div>
            </div>
          </q-card-section>
          <q-card-actions align="right">
              <q-btn label="Submit" type="submit" class='text-white bg-[#967259]'/>
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>
  </div>
</q-page>
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
          class="bg-red-600 text-white rounded w-full"
        />
      </div>
    </q-card-actions>
  </q-card>
</q-dialog>

</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import SideBar from '../Essentials/SideBar.vue';
export default {
  components: {
    SideBar,
  },
  data() {
    return {
      isAdmin: 0,
      responseInformation: '',
      responseStatus: '',
      email: '',
      userProfileImage: null,
      username: '',
      fullname: '',
      firstname: '',
      middlename: '',
      lastname: '',
      position: '',
      arrowDirection: false,
      statuss: '',
      showModal: false,
      toggleDrawers: true,
      drawer: false,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      showMenuIcon: false,
      inventoryMenuVisible: false,
      statusCheckTimer: null,
      productionVisible: false,
      OpenLogout: false,
      modalVisible: false,
      // Another Data here
      showDropdown: false,
      selectedUserId: null,
      selectedUserName: null,
      columns: [
        { name: 'user', label: 'User', align: 'left', field: 'user' },
        { name: 'position', label: 'Position', align: 'left', field: 'position', sortable: true },
        { name: 'last_activity', label: 'Last Activity', align: 'left', field: 'last_activity', sortable: true },
        { name: 'account_created', label: 'Account Created', align: 'left', field: 'account_created', sortable: true },
        { name: 'statuss', label: 'Status', align: 'left', field: 'statuss', sortable: true },
        { name: 'action', label: 'Action', align: 'left', field: 'action', sortable: true },
      ],
      tableData: [],
      initialPagination: {
        page: 1,
        rowsPerPage: 10
      },
      openDropdownRow: -1,
      search: '',
      addUserModal: false,
      // Add user data
      fname: '',
      lname: '',
      bdate: '',
      gInput: null, // Gender Input
      cInput: '',
      avalue: '', // Address Value
      evalue: '', // Email Value
      cvalue: '', // Contact Value
      pvalue: '', //Password Value
      posvalue: '',
      options: [
        'Male','Female','Rather not to say'
      ],
      civilOptions: [
        'Single', 'Married'
      ],
      posOptions: [
        'Owner', 'Warehouseman', 'Production Staff'
      ],
      showPassword: false,
      showEditArea: false,
      value: false,
    };
  },
  computed: {
    filteredTableData() {
      const searchTerm = this.search.toLowerCase();
      return this.tableData.filter(item =>
        item.user.name.toLowerCase().includes(searchTerm) ||
        item.user.email.toLowerCase().includes(searchTerm)
      );
    },
  },
  mounted() {
  this.loadUserData();
  this.FetchUser();
  this.statusCheckTimer = setInterval(() => {
    this.checkUserStatus();
    }, 5 * 1000); // 5 minutes (in milliseconds)
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    AddUser(){
      this.addUserModal = true;
      this.generatePassword();
    },
    validateAge(birthdate) {
        // Calculate the user's age based on the provided birthdate
        const today = new Date();
        const dob = new Date(birthdate);
        const age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        // Check if the user is 18 years or older
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            return age - 1 >= 18;
        }

        return age >= 18;
    },
    toggleClicked(id,value) {
      console.log(id);
      let storeValue = 0;
      if(value === true){
        storeValue = 1;
        console.log(storeValue);
      }else if(value === false){
        storeValue = 0;
        console.log(storeValue);
      }
      const formData = {
        userId: id,
        status: storeValue,
        type: 3
      }
      axios.post(`http://localhost/Capstone-Project/backend/api/Usermanagement/userdata.php/`, formData)
      .then(response => {
        const Status = response.data.status;
        const message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: 'Status Updated!!',
              caption: `${message}`,
              color: 'green',
          });
          this.FetchUser();
        }
        if (Status === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${message} Please try again.`,
          });
        }
      }).catch(error => {
            console.error('Error fetching data:', error);
      });
    },
    FetchUser(){
      axios.get('http://localhost/Capstone-Project/backend/api/Usermanagement/userdata.php?select=all')
      .then(response => {
        console.log(response.data);
        this.tableData = response.data.informations.rows.map(row => {
          const time = new Date(row.account_created).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

          const fullname = row.firstname + " " + row.lastname;
          return {
            id: row.personelID,

              userInfo: {
                firstname: row.firstname,
                lastname: row.lastname,
                birthday: row.birthdate,
                gender: row.gender,
                address: row.address,
                email: row.email,
                civil_status: row.civil_status,
                mobile_number: row.mobile_number,
                password: row.password,
                position: row.position,
              },
              user: {
                name: row.firstname + " " + row.lastname,
                email: row.email,
                image: row.profile_pic,
              },
              position: row.position,
              last_activity: row.action,
              account_created: time, // Add the formatted time property
              statuss: row.status,
              value: row.status === 1 ? true : false
            };
        });
      }).catch(error => {
        console.error('Error fetching data:', error);
      });
    },
    getUserImagePublicPath(image) {
      if (image) {
        // Use the correct path relative to the 'public' directory
        return `/pfp/${image}`;
      } else {
        // Return a default path or handle it as per your requirement
        return '/default_profile.png';
      }
    },
    toggleDropdown(index) {
      this.openDropdownRow = this.showDropdown ? index : -1; // Update the openDropdownRow
    },
    openDropdown(userId, userName, firstname, lastname, birthday, gender, civil_status, address,email,mobile_number,password, position) {
      this.showEditArea = true;
      this.selectedUserId = userId;
      this.selectedUserName = userName;

      this.fname = firstname;
      this.lname = lastname;
      this.bdate = birthday;
      this.gInput = gender;
      this.cInput = civil_status;
      console.log(this.cInput);
      this.avalue = address;
      this.evalue = email;
      this.cvalue = mobile_number;
      this.posvalue = position;
    },
    generatePassword() {
      const length = 12;
      const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-+=<>?/"; // Include special characters if needed
      let password = "";
      for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        password += charset.charAt(randomIndex);
      }
      this.pvalue = password;
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    onSubmit() {
      const formData = {
        fname: this.fname,
        lname: this.lname,
        bdate: this.bdate,
        gInput: this.gInput,
        cInput: this.cInput,
        avalue: this.avalue,
        evalue: this.evalue,
        cvalue: this.cvalue,
        posvalue: this.posvalue,
        type: 2
      };
      // console.log(formData)
      axios.post(`http://localhost/Capstone-Project/backend/api/Usermanagement/userdata.php`, formData)
      .then(response => {
        console.log(response.data)
        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: 'User Added!!',
              caption: `${Message}`,
              color: 'green',
          });
          this.fname = '';
          this.lname = '';
          this.bdate = ''; // Reset other form fields
          this.gInput = '';
          this.cInput = '';
          this.avalue = '';
          this.evalue = '';
          this.cvalue = '';
          this.pvalue = '';
          this.posvalue = '';
          this.addUserModal = false;
          this.FetchUser();
        }
        if (Status === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${Message} Please try again.`,
          });
        }
      }).catch(error => {
            console.error('Error Uploading data:', error);
      });
    },
    onSubmitEdit(){
      const formData = {
        id: this.selectedUserId,
        fname: this.fname,
        lname: this.lname,
        bdate: this.bdate,
        gInput: this.gInput,
        cInput: this.cInput,
        avalue: this.avalue,
        evalue: this.evalue,
        cvalue: this.cvalue,
        posvalue: this.posvalue,
        type: 3
      };
      axios.put(`http://localhost/Capstone-Project/backend/api/Usermanagement/userdata.php/${this.selectedUserId}`, formData)
      .then(response => {
        const Status = response.data.status;
        const Message = response.data.message;
        console.log(response.data.informations)
        if (Status === "success") {
          this.showEditArea = false;
          this.showDropdown = false;
          this.$q.notify({
              message: 'User Updated!!',
              caption: `${Message}`,
              color: 'green',
          });
          this.fname = '';
          this.lname = '';
          this.bdate = ''; // Reset other form fields
          this.gInput = '';
          this.cInput = '';
          this.avalue = '';
          this.evalue = '';
          this.cvalue = '';
          this.pvalue = '';
          this.posvalue = '';
          this.showEditArea = false;

          this.FetchUser();
        }
        if (Status === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${Message} Please try again.`,
          });
        }
      }).catch(error => {
          console.error('Error Uploading data:', error);
      });
    },
    openEditDialog(){
      this.showEditArea = true;
      this.showDropdown = false;
    },
    closeDialog() {
      this.selectedUserId = '';
      this.fname = '';
      this.lname = '';
      this.bdate = '';
      this.gInput = '';
      this.cInput = '';
      this.avalue = '';
      this.evalue = '';
      this.cvalue = '';
      this.pvalue = '';
      this.posvalue = '';
      this.showDropdown = false;
    },
    closeEditDialog() {
      this.selectedUserId = '';
      this.fname = '';
      this.lname = '';
      this.bdate = '';
      this.gInput = '';
      this.cInput = '';
      this.avalue = '';
      this.evalue = '';
      this.cvalue = '';
      this.pvalue = '';
      this.posvalue = '';
      // Add your logic to hide the edit area
      this.showEditArea = false;
    },



    // Old Data
    toggleProduction(){
      this.productionVisible = !this.productionVisible;
    },
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
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
          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;
          this.position = userInformation.position;
          this.status = userInformation.status;
          this.isAdmin = userInformation.isAdmin;
          this.fullname = this.firstname + " " + this.lastname;
          if (this.isAdmin === 1 || this.isAdmin === '1') {

            this.$router.push('/dashboard/usermanagement-section');
          } else {

            this.$q.notify({
              type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }

          if (this.status === 0 && !this.isAdmin) {
            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the administrator.',
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
    formatDate(dateString) {
      const options = { month: 'long', day: 'numeric', year: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
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
    toggleModal() {
      this.arrowDirection = !this.arrowDirection;
      this.showModal = !this.showModal;
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
<style lang="sass">
.my-sticky-header-table
  /* height or max-height is important */
  height: 350px

  .q-table__top,

  thead tr:first-child th
    background: white
    text-align: center
    font-size: 13px

  thead tr th
    position: sticky
    z-index: 1
  thead tr:first-child th
    top: 0

  /* this is when the loading indicator appears */
  &.q-table--loading thead tr:last-child th
    /* height of all previous header rows */
    top: 48px

  /* prevent scrolling behind sticky top row on focus */
  tbody
    /* height of all previous header rows */
    scroll-margin-top: 48px

</style>
