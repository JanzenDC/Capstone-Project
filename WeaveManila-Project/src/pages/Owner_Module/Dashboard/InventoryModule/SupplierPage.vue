<template>
<q-drawer
show-if-above
v-model="drawer"
side="left"
bordered
:width="drawerWidth">
  <ul class="p-2 flex flex-col h-full static" v-if="drawerWidth !== 80">
    <div @click="toggleDrawer" class="absolute -right-4 top-4 text-[18px] bg-white drop-shadow-lg rounded-full px-2 py-1 text-center cursor-pointer">
      <q-icon :name="drawerIcon"/>
    </div>
    <div class="flex">
      <div class="w-1/4 items-center flex justify-center" >
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[50px] md:w-[60px]"
        />
      </div>
      <div class=" items-center flex justify-center" v-if="drawerWidth <= 80">
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[150px] md:w-[60px]"
        />
      </div>
        <div class="text-[#281c0f] w-3/4" v-if="drawerWidth !== 80">
          <span class=" font-bold text-[20px]">WEAVEMANILA INC.</span><br>
          <span class="text-[#281c0f] text-[12px]">Production Monitoring & Inventory Management System</span>

        </div>
    </div>



    <li class="font-bold">Overview</li>
      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center">
          <router-link to="/dashboard/main-dashboard">
          <q-icon name="dashboard" class="mr-2" /> <span >Dashboard</span>
          </router-link>
        </div>
      </li>
      <!-- Process Section -->
      <li class="font-bold" >Process</li>
      <li class="py-[10px] px-[20px]" @click="toggleInventoryMenu">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/> <span >Inventory</span></div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="inventoryMenuVisible">
          <router-link to="/dashboard/supplier-section">
            <li class="py-[2px] px-[40px] mt-3">Materials</li>
          </router-link>
          <router-link to="/dashboard/supplier-section">
            <li class="py-[2px] px-[40px] mt-3">Supplier List</li>
          </router-link>
          <li class="px-[40px] mt-3">Purchase Order</li>
        </ul>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2">
          <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <q-icon name="description" class="mr-2"/><span >Production Cost Report</span>
        </div>
      </li>
      <!-- Settings Section -->
      <li class="font-bold" >Settings</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/auditlogs-section">
            <i class="bi bi-activity mr-2"></i> <span >Audit Logs</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/usermanagement-section">
            <q-icon name="group" class="mr-2"/> <span >User Management</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/account-settings">
            <q-icon name="manage_accounts" class="mr-2"/> <span >Account Settings</span>
          </router-link>
        </div>
      </li>
      <li class="mt-auto py-[10px]">
        <div class="flex justify-between text-center" >
          <div class="flex items-center" >
            <q-img
              :src="getUserProfileImagePath()"
              alt="Description of the image"
              class="w-12 md:w-12 rounded-full"
            />
            <div class="ml-2 overflow-hidden">
              <div class="whitespace-nowrap overflow-hidden text-overflow-ellipsis font-bold">
                {{ getLimitedFullname(fullname, 25) }}
              </div>
              <div class="text-center">
                {{ position }}
              </div>
            </div>
          </div>
          <div class="flex items-center ">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
          </div>
        </div>
      </li>
  </ul>

  <ul class="p-2 flex flex-col h-full static" v-if="drawerWidth <= 80">
    <div @click="toggleDrawer" class="absolute -right-4 top-4 text-[18px] bg-white drop-shadow-lg rounded-full px-2 py-1 text-center cursor-pointer">
      <q-icon :name="drawerIcon"/>
    </div>
    <div class="flex">
      <div class=" items-center flex justify-center" v-if="drawerWidth <= 80">
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[150px] md:w-[60px]"
        />
      </div>
    </div>


      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="dashboard" />
        </div>
      </li>
      <!-- Process Section -->

      <li class="py-[10px] px-[20px]" @click="toggleDrawer">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/></div>
        </div>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2" @click="toggleDrawer">
          <i class="bi bi-box-seam"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="description" />
        </div>
      </li>
      <!-- Settings Section -->
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <i class="bi bi-activity"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="group" class="mr-2"/>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="manage_accounts"/>
        </div>
      </li>
      <li class="mt-auto py-[10px]">
          <div class="flex justify-center ">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
          </div>
      </li>
  </ul>
</q-drawer>
  <q-page class="bg-[#f5f5f5] p-4">
    <div class="text-[30px]">
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
      <span class="font-bold text-[#634832]">Supplier List</span>
      </div>
      <div class="text-[16px] text-[#967259]">Description for the supplier list goes here</div>
    </div>

    <div class="bg-white px-4 py-3 mt-10">

      <div class="md:flex md:items-end md:justify-end ">
        <div class="grid-cols-2 grid gap-2 md:flex items-center md:gap-5">
          <q-input v-model="search" outlined dense placeholder="Search" class="md:w-[400px] ">
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-input>
          <q-btn @click="addSupplier = true" class="bg-[#281c0f] text-white">
            <i class="bi bi-plus-lg"></i>
            Add Supplier
          </q-btn>
          <q-btn v-if="selected.length > 0" @click="Remove" class="bg-red-600 text-white">
            <q-icon name="delete"/>
            Remove
          </q-btn>
        </div>
      </div>

<!-- Add supplier Modal -->
<q-dialog v-model="addSupplier">
      <q-card class="w-[388px]">
        <q-form @submit="onSubmit">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6 font-bold">Add Supplier</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section class="scroll">
          <label> <!--Supplier Name-->
            Supplier Name<span class="text-red-600">*</span>
          </label>
          <q-input type="text" label="Supplier Name" v-model="suppName"  outlined dense :rules="[val => !!val || 'Field is required']"/>

          <label> <!--Supplier Address-->
            Supplier Address<span class="text-red-600">*</span>
          </label>
          <q-input type="text" label="Supplier Address" v-model="suppAddress"  outlined dense :rules="[val => !!val || 'Field is required']"/>

          <label>
            Contact Person<span class="text-red-600">*</span>
          </label>
          <q-input type="text" label="Contact Person" v-model="suppName"  outlined dense :rules="[val => !!val || 'Field is required']"/>

          <label>
            Contact Number<span class="text-red-600">*</span>
          </label>
          <q-input type="tel" label="Contact Number" v-model="suppCp"  outlined dense :rules="[val => !!val || 'Phone Number is required', val => /^09\d{9}$/g.test(val) || 'Invalid Phone Number']"/>

          <label>
            Email<span class="text-red-600">*</span>
          </label>
          <q-input type="Email" label="Email" v-model="suppEmail"  outlined dense :rules="[val => !!val || 'Field is required']"/>

        </q-card-section>

        <q-separator />

        <q-card-actions align="right">
          <q-btn flat label="Cancel" color="primary" v-close-popup />
          <q-btn
            @click="onSubmit"
            flat
            label="Save"
            type="submit"
            icon="save"
            size="md"
            class="bg-[#281c0f] text-white rounded"
          />
        </q-card-actions>
      </q-form>
      </q-card>
  </q-dialog>


      <div class="py-5">
        <q-table
          class="my-sticky-header-table"
          flat bordered
          :rows="filteredTableData"
          :columns="columns"
          row-key="supplierID"
          :selected-rows-label="getSelectedString"
          selection="multiple"
          v-model:selected="selected"
        >
        <template v-slot:body-cell-selection="props">
          <q-td :props="props">
            <q-checkbox
              v-model="props.selected"
              :val="props.row.supplierID"
              @input="handleCheckboxChange(props.row.supplierID)"
            />
          </q-td>
        </template>
        </q-table>
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
        id: '',
        email: '',
        fullname: '',
        firstname: '',
        middlename: '',
        lastname: '',
        userProfileImage: null,
        username: '',
        position: '',
        status: '',
        addCategory: false,
        drawer: false,
        showMenuIcon: false,
        statusCheckTimer: null,
        toggleDrawers: true,
        drawerWidth: 300,
        drawerIcon: 'arrow_back_ios',
        inventoryMenuVisible: false,

        // Add DATA
        addSupplier: false,
        columns : [

        {name: 'supplier', label: 'Supplier', field: 'supplier'},
        {name: 'contact_person', label: 'Contact Person', field: 'contact_person'},
        {name: 'address', label: 'Address', field: 'address'},
        {name: 'contact', label: 'Contact', field: 'contact'},
        {name: 'email', label: 'Email', field: 'email'},
        {name: 'actions', label: 'Actions', field: 'actions'},
      ],
      rows : [],
      selected: [],
      search: '',
      };
    },
    computed: {
      filteredTableData() {
      const searchQuery = this.search.toLowerCase();
        return this.rows.filter(row =>
          row.supplier.toLowerCase().includes(searchQuery) ||
          row.contact_person.toLowerCase().includes(searchQuery) ||
          row.email.toLowerCase().includes(searchQuery)
        );
      },
    },
    mounted() {
      this.loadUserData();
      this.statusCheckTimer = setInterval(() => {
        this.checkUserStatus();

      }, 20 * 1000); // 1 second (in milliseconds)
      this.fetchData();
    },
    beforeUnmount() {
      clearInterval(this.statusCheckTimer);
    },
    methods: {
      // New Data
      fetchData(){
        this.rows = [];
        axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php?get=alldata`)
        .then(response => {
          this.rows = response.data.information.values.map(row => {
            return {
              supplierID: row.supplierID,
              supplier: row.supplier_name,
              contact_person: row.contact_person,
              address: row.address,
              contact: row.contact,
              email: row.email,
            };
          })
        }).catch(error => {
              console.error('Error fetching data:', error);
        });
      },
      handleCheckboxChange(rowId) {
        const index = this.selected.indexOf(rowId);

        if (index === -1) {
          this.selected.push(rowId);
        } else {
          this.selected.splice(index, 1);
        }

      },
      getSelectedString() {
        return `Selected ${this.selected.length} item(s)`;

      },
      extractSelectedIds() {
        return this.selected.map(item => item.supplierID);
      },
      Remove() {
        const selectedIds = this.extractSelectedIds();
        axios.delete(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php/${this.id}`, {
          data: { selectedIds: selectedIds },
        }).then((response) => {
          console.log(response.data);
          // Handle response as needed
        }).catch(error => {
          console.error('Error fetching data:', error);
        });

        this.selected = [];
      },





      // Old data
      toggleInventoryMenu() {
        this.inventoryMenuVisible = !this.inventoryMenuVisible;
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
          const Position = response.data.information.position;
          if (Position.toLowerCase() === 'owner') {
            this.$router.push('/dashboard/supplier-section');
          }else{
            this.$q.notify({
            type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }
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
            this.id = userInformation.id;

            this.fullname = this.firstname + " " + this.lastname;
            if (this.position.toLowerCase() === 'owner') {
              this.$router.push('/dashboard/supplier-section');
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

<style lang="sass">
.my-sticky-header-table
  /* height or max-height is important */
  height: 400px

  .q-table__top,

  thead tr:first-child th
    /* bg color is important for th; just specify one */
    background-color: #967259
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
