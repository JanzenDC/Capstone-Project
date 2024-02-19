<template>
<q-drawer
show-if-above
v-model="drawer"
side="left"
bordered
:width="drawerWidth">
  <ul class=" p-2 flex flex-col h-full static" v-if="drawerWidth !== 80">
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
      <div class="text-[#281c0f] text-[18px] w-3/4 flex justify-center items-center gap-1" v-if="drawerWidth !== 80">
      <div>
        <span class="font-bold ">WEAVEMANILA INC.</span><br>
      </div>
      <div>
        <q-icon name="keyboard_double_arrow_right" class="text-[30px] cursor-pointer" @click="toggleDrawer" />
      </div>
    </div>

    </div>



    <li class="font-bold mt-5">Menu</li>
      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center">
          <router-link to="/dashboard/main-dashboard">
          <q-icon name="dashboard" class="mr-2" /> <span >Dashboard</span>
          </router-link>
        </div>
      </li>

      <li class="py-[10px] px-[20px]" @click="toggleInventoryMenu">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/> <span >Inventory</span></div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="inventoryMenuVisible">
          <router-link to="/dashboard/inventory-section">
            <li class="py-[2px] px-[40px] mt-3">Materials</li>
          </router-link>
          <router-link to="/dashboard/mpoform-section">
            <li class="px-[40px] mt-3"> Material Purchase Order</li>
          </router-link>
        </ul>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2">
          <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <q-icon name="assignment_add" class="mr-2"/><span>Report</span>
        </div>
      </li>
      <!-- Settings Section -->
      <li class="font-bold" >Admin</li>
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
        <q-separator />
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

    <div class="flex justify-center items-center text-[40px]">
      <div class=" items-center flex justify-center cursor-pointer" v-if="drawerWidth <= 80">
        <q-icon name="keyboard_double_arrow_right" @click="toggleDrawer"/>
      </div>
    </div>

      <li class="mt-5 text-center">Menu</li>
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
      <li class="text-center">Admin</li>
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
<q-page class="bg-[#f5f5f5] ">
  <div class="text-[30px] bg-white p-2 ">
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
    <span class="font-bold">Purchase List</span>
    </div>
    <div class="text-[16px]"><span class="text-[#b8b8b8]">Inventory / </span>Purchase List</div>
  </div>

  <div class="p-4">
    <div class="flex mt-3">
      <router-link to="/dashboard/mpoform-section">
        <div class="flex w-[155px] text-[#b8b8b8] border-t-2 border-l-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="note_add"/>
          <p>MPO Form</p>
        </div>
      </router-link>
      <router-link to="/dashboard/mpo-section">
        <div class="flex bg-white w-[155px] border-r-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="list"/>
          <p>Purchase list</p>
        </div>
      </router-link>
      <router-link to="/dashboard/supplier-section">
        <div class="flex w-[155px] text-[#b8b8b8] border-t-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="group"/>
            <p>Supplier List</p>
          </div>
      </router-link>
    </div>

    <div class="w-full bg-white p-4">
      <div class="flex md:items-end md:justify-between">
          <div class="flex items-center gap-2">
            <q-input outlined dense placeholder="Search" class="md:w-[400px]">
              <template v-slot:prepend>
                <q-icon name="search" />
              </template>
            </q-input>
          </div>
          <div class="flex items-center gap-2">
            <q-btn-dropdown square icon="download">
              <q-list>
                <q-item clickable v-close-popup >
                  <q-item-section>
                    <q-item-label>Excel</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable v-close-popup>
                  <q-item-section>
                    <q-item-label>PDF</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
            <q-btn square icon="print"/>
            <q-btn square icon="cached" @click="refreshData"/>
          </div>
        </div>
      <div class="q-pa-md">
        <q-table
            :rows="rows"
            :columns="columns"
            row-key="mpo_id"
            class="my-sticky-header-table"
            :dense="$q.screen.lt.md"
            flat bordered
            selection="multiple"
            v-model:selected="selected"
            :selected-rows-label="getSelectedString"
          >
          <template v-slot:body-cell-selection="props">
            <q-td :props="props">
              <q-checkbox
                v-model="props.selected"
                :val="props.row.mpo_id"
                @input="handleCheckboxChange(props.row.mpo_id)"
              />
            </q-td>
          </template>


        <template v-slot:body-cell-status="props">
              <q-td :props="props">
                <span v-if="props.row.status === 'Recieved'" class="text-green-600 p-2 rounded-full bg-green-300">
                  ● Recieved
                </span>
                <span v-else-if="props.row.status === 'Pending'" class="text-red-600 p-2 rounded-full bg-red-300">
                  ● Pending
                </span>
                <span v-else-if="props.row.status === 'Partial Recieved'" class="text-yellow-600 p-2 rounded-full bg-yellow-300">
                  ● Partial Recieved
                </span>
              </q-td>
          </template>

          <template v-slot:body-cell-actions="props">
              <q-td :props="props">
                <div class="flex items-center justify-center w-[221px] gap-1">
                  <div class="bg-[#ddffcd] py-1 px-2 text-green-600 rounded font-bold">
                    Recieved
                  </div>
                  <div class="bg-[#475467] text-white w-[32px] h-[32px] text-[20px]">
                    <q-icon name="history" />
                  </div>
                  <div class="bg-[#26218e] text-white w-[32px] h-[32px] text-[20px]">
                    <q-icon name="assignment"/>
                  </div>
                  <div class="bg-[#b3261e] text-white text-[20px] w-[32px] h-[32px]">
                    <q-icon name="delete"/>
                  </div>
                  <div class="w-[32px] h-[32px] text-[20px]">
                    <q-icon name="arrow_forward_ios"/>
                  </div>
                </div>
              </q-td>
          </template>

        </q-table>
      </div>
    </div>

  </div>



</q-page>
</template>

<script>

import { SessionStorage } from 'quasar';
import axios from 'axios';

export default {
  data() {
    return {
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

      // Additional Data
      firstStep: false,
      secondStep: false,
      columns: [
        { name: 'mpo_number', align: 'left', label: 'MPO No.', field: 'mpo_number', sortable: true, headerStyle: 'width: 44px;' },
        { name: 'supplier', align: 'left', label: 'Supplier', field: 'supplier', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'product', align: 'left', label: 'Product', field: 'product', sortable: true, headerStyle: 'width: 150px;' },
        { name: 'date_purchase', align: 'left', label: 'Date Purchase', field: 'date_purchase', sortable: true, headerStyle: 'width: 120px;' },
        { name: 'qty', align: 'left', label: 'Qty', field: 'qty', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'qty_recieved', align: 'left', label: 'Qty Recieved', field: 'qty_recieved', sortable: true, headerStyle: 'width: 120px;' },
        { name: 'amount', align: 'left', label: 'Amount', field: 'amount', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'actions', align: 'center', label: 'Actions', field: 'actions', sortable: true },

      ],

      rows: [],
      selected: [],


    };
  },
  mounted() {
    this.loadUserData();
    this.fetchMPOdata();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    refreshData(){
      this.fetchMPOdata();
    },
    fetchMPOdata(){
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=alldata`)
      .then(response => {
        console.log(response.data);
        this.rows = response.data.categoryData.map(row => {

          let mpo_status = row.status;

          let status = '';
          if (mpo_status === 2) {
              status = 'Recieved';
          } else if (mpo_status == 1) {
              status = 'Partial Recieved';
          } else {
              status = 'Pending';
          }
          return {
            mpo_id: row.mpoID,
            mpo_number: row.mpo_ref_no,
            supplier: row.supplier_name,
            product: row.product_description,
            date_purchase: row.date_purchased,
            qty: row.quantity,

            amount: row.total_amount,
            status: status,
          };
        })
      })
      .catch(error => {
        // Handle any errors that occur during the HTTP request
        console.error('Error fetching data:', error.message);
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
          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;
          this.position = userInformation.position;
          this.status = userInformation.status;

          this.fullname = this.firstname + " " + this.lastname;
          if (this.position.toLowerCase() === 'owner') {

            this.$router.push('/dashboard/mpo-section');
          } else {

            this.$q.notify({
              type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }

          if (this.status == 0) {

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
  height: 370px

  .q-table__top,

  thead tr:first-child th
    /* bg color is important for th; just specify one */
    background-color: #fff
    color: #000
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

