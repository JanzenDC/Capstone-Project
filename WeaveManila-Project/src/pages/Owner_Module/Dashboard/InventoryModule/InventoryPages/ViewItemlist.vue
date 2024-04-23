<template>
<SideBar />
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
        <span class="font-bold">Weavers List</span>
        <div class="text-[16px] text-[#999999]">        
          <p class="font-bold text-[#755e4a]">{{ category_name }}</p>
          <p class="text-[16px] text-[#755e4a]">Inventory / {{ category_name }}</p>
        </div>
      </div>
    </div>
    <LogoutTop />
  </div>
  <div class="p-4">
    <div class="flex mt-8">
      <router-link to="/dashboard/inventory-viewpage">
        <div class="flex w-[128px] text-[#89909e] border-t-2 border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="summarize"/>
          <p>Summary</p>
        </div>
      </router-link>
      <router-link to="/dashboard/inventory-viewlist">
          <div class="flex bg-white w-[128px] border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="list"/>
            <p>Items List</p>
          </div>
      </router-link>
    </div>
    <div class="w-full bg-white p-4">
      <div class="flex md:items-end md:justify-between">
        <div class="">
          <q-input outlined dense placeholder="Search" class="md:w-[400px]">
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-input>

        </div>
        <div class="flex items-center gap-2">
          <q-btn-dropdown square icon="download">
            <q-list>
              <q-item clickable v-close-popup @click="downloadExcel">
                <q-item-section>
                  <q-item-label>Excel</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-close-popup @click="generatePDF">
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
      <q-separator class="mt-3" />
        <div id="content">
          <q-table
            :rows="rows"
            :columns="columns"
            row-key="mpo_id"
            class="my-sticky-header-table"
            selection="multiple"
            v-model:selected="selected"
            :selected-rows-label="getSelectedString"
          >
          <template v-slot:body-cell-item="props">
            <q-td :props="props">
              <div v-for="item in props.row.item" :key="item">{{ item }}</div>
            </q-td>
          </template>

          <template v-slot:body-cell-balance="props">
            <q-td :props="props">
              <div v-for="balance in props.row.balance" :key="balance">{{ balance }}</div>
            </q-td>
          </template>

          <template v-slot:body-cell-total="props">
            <q-td :props="props">
              <div v-for="total in props.row.total" :key="total">{{ total }}</div>
            </q-td>
          </template>

          <template v-slot:body-cell-status="props">
            <q-td :props="props">
              <div v-for="status in props.row.status" :key="status">
                <q-badge :color="getStatusColor(status)">
                  {{ status }}
                </q-badge>
              </div>
            </q-td>
          </template>

          <template v-slot:body-cell-action="props">
            <q-td :props="props">
              <div class="flex items-center w-[180px] gap-2">
                <div class="w-[32px] h-[32px] text-[20px] bg-[#344054] text-white text-center rounded ">
                  <q-icon name="history"/>
                </div>
                <div class="w-[32px] h-[32px] text-[20px] bg-[#26218e] text-white text-center rounded ">
                  <q-icon name="assignment"/>
                </div>
                <div class="w-[32px] h-[32px] text-[20px] bg-[#b3261e] text-white text-center rounded ">
                  <q-icon name="delete"/>
                </div>
                <div class="w-[32px] h-[32px] text-[20px] bg-white text-black text-center rounded ">
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
import ExcelJS from 'exceljs';
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import SideBar from '../../Essentials/SideBar.vue';
import LogoutTop from '../../Essentials/LogoutTop.vue';

export default {
  components: {
    SideBar,
    LogoutTop
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

      // Additional Data
      category_id: '',
      category_name: '',
      columns : [
      { name: 'mpo_number', align: 'left', label: 'MPO No.', field: 'mpo_number', sortable: true },
      { name: 'date_purchased', align: 'left', label: 'Date Purchased', field: 'date_purchased', sortable: true },
      { name: 'supplier', align: 'left', label: 'Supplier', field: 'supplier', sortable: true },
      { name: 'item', align: 'left', label: 'Product', field: 'item', sortable: true },
      { name: 'balance', align: 'left', label: 'Qty Purchased', field: 'balance', sortable: true},
      { name: 'total', align: 'left', label: 'Qty', field: 'total', sortable: true},
      { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true},
      { name: 'edited', align: 'left', label: 'Edited', field: 'edited', sortable: true},
      { name: 'action', align: 'left', label: 'Action', field: 'action', sortable: true},
    ],
    rows: [],
    selected: [],
    };
  },
  mounted() {
    this.loadUserData();
    this.loadCategoryData();
    this.fetchMPOData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
      this.checkCategoryStatus();
    }, 50 * 1000);
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    onMainDashboard(){
      this.$router.push('/dashboard/main-dashboard');
    },
    loadCategoryData() {
      const categoryData = SessionStorage.getItem('inventoryData');
      if (categoryData) {
        try {
          const categInformation = JSON.parse(categoryData);
          this.category_id = categInformation.InventoryId;
          this.category_name = categInformation.InventoryName;

        } catch (error) {
          console.log('Error parsing user data:', error);
          // Provide user feedback or navigate to an error page
          this.$q.notify({
            type: 'negative',
            message: 'Error loading category data. Please try again.',
          });
          this.$router.push('/dashboard/inventory-section');
          sessionStorage.removeItem('inventoryData');
        }
      } else {
        // Handle the case when user data is not available
        this.$router.push('/dashboard/inventory-section');
        sessionStorage.removeItem('inventoryData');
      }
    },
    checkCategoryStatus() {
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php?type&id=${this.category_id}`)
      .then(response => {
        const inventoryData = {
          InventoryId: this.category_id,
          InventoryName: this.category_name,
        }
        SessionStorage.set('inventoryData', JSON.stringify(inventoryData));
      }).catch(error => {
            console.error('Error fetching data:', error);
      });
    },

    fetchMPOData() {
      this.rows = [];
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php?type=2&id=${this.category_id}`)
        .then(response => {
          console.log(response.data);
          // Grouping data by mpoID
          const groupedData = response.data.categoryData.reduce((acc, row) => {
            if (!acc[row.mpoID]) {
              acc[row.mpoID] = {
                mpo_id: row.mpoID,
                mpo_number: row.mpo_ref_no,
                date_purchased: row.date_purchased,
                supplier: row.supplier_name,
                item: [],
                balance: [],
                total: [],
                status: []
              };
            }
            acc[row.mpoID].item.push(row.item_name);
            acc[row.mpoID].balance.push(row.quantity);
            acc[row.mpoID].total.push(row.quantity_received);
            acc[row.mpoID].status.push(this.calculateStatus(row.quantity_received));
            return acc;
          }, {});

          // Converting grouped data object into rows array
          this.rows = Object.values(groupedData);
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
    getStatusColor(status) {
      switch (status) {
        case 'Out of Stock':
          return 'red';
        case 'Low Stock':
          return 'yellow';
        case 'In Stock':
          return 'green';
        default:
          return 'gray'; // or any default color for other statuses
      }
    },
    calculateStatus(quantity_received) {
      if (quantity_received === 0 || quantity_received === null || quantity_received === undefined) {
        return 'Out of Stock';
      } else if (quantity_received < 500) {
        return 'Low Stock';
      } else {
        return 'In Stock';
      }
    },
    refreshData(){
      this.fetchMPOData();
    },
    downloadExcel() {
      const workbook = new ExcelJS.Workbook();
      const worksheet = workbook.addWorksheet('Sheet 1');

      // Add headers
      const headers = this.columns.map(column => column.label);
      worksheet.addRow(headers);

      // Add data rows
      this.rows.forEach(row => {
        const rowData = this.columns.map(column => row[column.field]);
        worksheet.addRow(rowData);
      });
      workbook.xlsx.writeBuffer().then(buffer => {
        const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = `weavemanila_${this.category_name}.xlsx`;
        link.click();
      });
    },
    generatePDF() {
      const doc = new jsPDF();

      const tableData = this.rows.map(row => {
        return [
          row.mpo_number,
          row.date_purchased,
          row.supplier,
          row.item.join('\n'), // Concatenate items with new lines
          row.balance.join('\n'), // Concatenate balances with new lines
          row.total.join('\n'), // Concatenate totals with new lines
          row.status.join('\n') // Concatenate statuses with new lines
        ];
      });

      doc.autoTable({
        head: [['MPO Number', 'Date Purchased', 'Supplier', 'Item', 'Balance', 'Total', 'Status']],
        body: tableData
      });

      doc.save("inventory.pdf");
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

    toggleProduction(){
      this.productionVisible = !this.productionVisible;
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
          if (this.position.toLowerCase() === 'owner') {

            this.$router.push('/dashboard/inventory-viewlist');
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
  height: 300px

  .q-table__top,

  thead tr:first-child th
    /* bg color is important for th; just specify one */
    background-color: #fff
    color: #000

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
