<template>
<q-header elevated class="bg-white w-full text-black h-[100px]  md:flex md:justify-between border-2">
  <div class="md:w-[400px] p-4 md:flex min-[390px]:hidden">
      <div>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        <q-img
          src="../../../../assets/favicon-128x128.png"
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
  <div class="bg-white md:h-[520px] rounded p-10 overflow-y-auto">
    <div class="flex justify-between items-center">
      <router-link to="/dashboard/account-settings">
        <p class="text-[15px]"><q-icon name="arrow_back_ios"/> <span class=" font-bold text-[#9e896a]">User Management</span></p>
      </router-link>
      <div class="flex items-center gap-5">
        <q-input v-model="search" outlined dense placeholder="Search" class="w-[400px]">
          <template v-slot:prepend>
            <q-icon name="search" />
          </template>
        </q-input>
        <q-btn @click="addUserModal = true">
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

      <q-card-section>
        <q-form @submit="onSubmit">
        <div class="text-h6 font-bold text-[#667085]">Personal Information</div>
        <div class="grid grid-cols-2 gap-5">
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
        <div class="text-h6 font-bold text-[#667085]">Security</div>
        <div class="grid grid-cols-2 gap-5">
          <!-- Password -->
          <div>
            <p class="text-[15px]">Password</p>
              <q-input
                class="w-full"
                v-model="pvalue"
                label="Password"
                outlined
                dense
                :type="showPassword ? 'text' : 'password'"
                :no-error-icon="true"
                :rules="[val => !!val || 'Password is required',
                          val => val.length >= 8 || 'Password must be at least 8 characters']"
              >
              <template v-slot:append>
                <span @click="togglePasswordVisibility">
                  <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                </span>
              </template>
              <template v-slot:after>
                <q-btn class="bg-[#667085] text-white text-[10px] w-[100px]" label="Generate Password" @click="generatePassword" size="xs"/>
              </template>
              </q-input>
          </div>
          <!-- Confirm Password -->
          <div>
            <p class="text-[15px]">Confirm Password</p>
            <q-input
              v-model="cpvalue"
              label="Confirm Password"
              type='password'
              outlined
              dense
              :no-error-icon="true"
              :rules="[val => !!val || 'Confirm Password is required',
                        val => val === pvalue || 'Passwords do not match']"
            >
            </q-input>
          </div>
        </div>
        <q-btn label="Submit" type="submit" />
      </q-form>

      </q-card-section>
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
        <q-td :props="props" class="flex items-center gap-4" >
          <q-img :src="getUserImagePublicPath(props.row.user.image)" :alt="props.row.user.name" class="w-[34px] rounded-full min-[390px]:hidden md:flex"/>
          <div class="min-[390px]:flex md:block min-[390px]:gap-2">
            <p class="font-bold">
            {{ props.row.user.name }}
            </p>
            {{ props.row.user.email }}
          </div>
        </q-td>
      </template>
      <!-- Status Components -->
      <template v-slot:body-cell-statuss="props">
        <q-td :props="props">
          <span v-if="props.row.statuss === 1" class="text-green-600 p-2 rounded-full bg-green-300">
            ● Active
          </span>
          <span v-else class="text-red-600 p-2 rounded-full bg-red-300">
            ● Inactive
          </span>
        </q-td>
      </template>

      <!-- Action Components -->
      <template v-slot:body-cell-action="props">
      <q-td :props="props">
        <q-btn
          @click="openDropdown(props.row.id, props.row.user.name,   props.row.userInfo.firstname,
          props.row.userInfo.lastname,
          props.row.userInfo.birthday,
          props.row.userInfo.gender,
          props.row.userInfo.civil_status,
          props.row.userInfo.address,
          props.row.userInfo.email,
          props.row.userInfo.mobile_number,
          props.row.userInfo.password)"
          class="font-bold text-[15px]"
        >
          ...
        </q-btn>
        <q-dialog v-model="showDropdown" persistent transition-show="scale" transition-hide="scale">
          <q-card style="width: 300px">
            <q-card-section>
              <p class="text-h6">User Configuration</p>
              <p class="q-mb-md">Choose the operational status for User ID {{ selectedUserId }} - {{ selectedUserName }}.</p>

              <q-item clickable v-on:click="setStatus(1, selectedUserId)">
                <q-item-section>
                  <div class="flex text-[16px] gap-2 items-center">
                    <q-icon name="check" color="positive" />
                    Active
                  </div>
                </q-item-section>
              </q-item>

              <q-item clickable v-on:click="setStatus(0, selectedUserId)">
                <q-item-section>
                  <div class="flex text-[16px] items-center">
                    <q-icon name="close" color="negative" />
                    <span class="q-ml-sm">Inactive</span>
                  </div>
                </q-item-section>
              </q-item>

              <q-item clickable>
                <q-item-section>
                  <div class="flex text-[16px] items-center" @click="openEditDialog()">
                    <q-icon name="edit_square" color="black" />
                    <span class="q-ml-sm">Edit</span>
                  </div>
                </q-item-section>
              </q-item>
            </q-card-section>
            <q-card-actions align="right">
              <q-btn flat color="primary" @click="closeDialog">Close</q-btn>
            </q-card-actions>
          </q-card>
        </q-dialog>


      </q-td>
      </template>

      </q-table>
    </div>

    <q-dialog v-model="showEditArea" >
      <q-card class="w-[600px]">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6 font-bold">Edit user</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section>
          <q-form @submit="onSubmitEdit">
          <div class="text-h6 font-bold text-[#667085]">Personal Information</div>
          <div class="grid grid-cols-2 gap-5">
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
          <div class="flex gap-2">
            <q-btn label="Submit" type="submit" />
            <q-btn flat color="primary" @click="closeEditDialog">Close</q-btn>
          </div>
        </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';

export default {
  setup () {
    const $q = useQuasar()
    return { $q };
  },
  data() {
    return {
      responseInformation: '',
      responseStatus: '',
      email: '',
      userProfileImage: null,
      username: '',
      firstname: '',
      middlename: '',
      lastname: '',
      position: '',
      arrowDirection: false,
      statuss: '',
      showModal: false,
      drawer: false,
      statusCheckTimer: null,

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
      cInput: null,
      avalue: '', // Address Value
      evalue: '', // Email Value
      cvalue: '', // Contact Value
      pvalue: '', //Password Value
      cpvalue: '', //Confirm Password Value
      options: [
        'Male','Female','Rather not to say'
      ],
      civilOptions: [
        'Single', 'Married'
      ],
      showPassword: false,
      showEditArea: false,
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

    FetchUser(){
      axios.get('http://localhost/Capstone-Project/backend/api/Usermanagement/userdata.php?select=all')
      .then(response => {
        this.tableData = response.data.informations.rows.map(row => {
          const time = new Date(row.account_created).toLocaleDateString('en-US', { year: 'numeric', month: 'numeric', day: 'numeric' });          const fullname = row.firstname + " " + row.lastname;
          return {
            id: row.id,

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
    openDropdown(userId, userName, firstname, lastname, birthday, gender, civil_status, address,email,mobile_number,password) {
      this.showDropdown = true;
      this.selectedUserId = userId;
      this.selectedUserName = userName;

      this.fname = firstname;
      this.lname = lastname;
      this.bdate = birthday;
      this.gInput = gender;
      this.cInput = civil_status;
      this.avalue = address;
      this.evalue = email;
      this.cvalue = mobile_number;
    },

    setStatus(status, userId) {
      this.showDropdown = false;
      const formData = {
        userId: userId,
        status: status,
        type: 1
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
    generatePassword() {
      const length = 12;
      const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-+=<>?/"; // Include special characters if needed
      let password = "";
      for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        password += charset.charAt(randomIndex);
      }
      this.pvalue = password;
      this.cpvalue = password;
      this.showPassword = false;
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
        pvalue: this.pvalue,
        cpvalue: this.cpvalue,
        type: 2
      };
      axios.post(`http://localhost/Capstone-Project/backend/api/Usermanagement/userdata.php`, formData)
      .then(response => {
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
          this.cpvalue = '';
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
        type: 3
      };
      console.log(formData);
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
          this.cpvalue = '';
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
      this.cpvalue = '';
      // Add your logic to hide the edit area
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
      this.cpvalue = '';
      // Add your logic to hide the edit area
      this.showEditArea = false;
    },
    // Old Data
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
          if(this.status == 0)
          {
            this.$q.notify({
            type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }
          // If another value add here
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
    /* bg color is important for th; just specify one */
    background-color: #667085
    color: #fff
    text-align: center
    font-size: 13px
    font-weight: bold

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
