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
        <div class="flex bg-white border-e-2 w-[128px] h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px] ">
          <q-icon name="summarize"/>
          <p>Summary</p>
        </div>
      </router-link>
      <router-link to="/dashboard/inventory-viewlist">
        <div class="flex text-[#89909e] border-t-2 border-e-2 w-[128px] h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="list"/>
          <p>Items List</p>
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
              <q-item clickable v-close-popup @click="downloadExcel">
                <q-item-section>
                  <q-item-label>Excel</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-close-popup @click="downloadPDF">
                <q-item-section>
                  <q-item-label>PDF</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
          <q-btn square icon="print" />
          <q-btn square icon="cached" @click="refreshData"/>
        </div>
      </div>
      <q-separator class="mt-3" />
        <q-table
          :rows="rows"
          :columns="columns"
          row-key="name"
          class="my-sticky-header-table"

        >
        <template v-slot:body-cell-status="props">
          <q-td :props="props">
            <span v-if="props.row.status === 'In Stock'" class="text-green-600 p-2 rounded-full bg-green-300">
              ● In Stock
            </span>
            <span v-else-if="props.row.status === 'Out of Stock'" class="text-red-600 p-2 rounded-full bg-red-300">
              ● Out of stock
            </span>
            <span v-else-if="props.row.status === 'Low Stock'" class="text-yellow-600 p-2 rounded-full bg-yellow-300">
              ● Low Stock
            </span>
          </q-td>
        </template>

        </q-table>
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
        { name: 'item', align: 'left', label: 'Item', field: 'item', sortable: true, headerStyle: 'width: 900px', },
        { name: 'total', align: 'left', label: 'QTY BALANCE', field: 'total', sortable: true, headerStyle: 'width: 100px', },

        { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true, headerStyle: 'width: 100px' },
      ],
      rows: [],
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
        console.log(categoryData);
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
        axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/inventory.php?type&id=${this.category_id}`)
        .then(response => {
          const inventoryData = {
            InventoryId: this.category_id,
            InventoryName: this.category_name,
          }
          console.log(inventoryData);
          SessionStorage.set('inventoryData', JSON.stringify(inventoryData));
        }).catch(error => {
              console.error('Error fetching data:', error);
        });
      },
      fetchMPOData(){
        this.rows = [];
        axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/inventory.php?type=2&id=${this.category_id}`)
        .then(response => {
          console.log(response.data);

          // Create an object to store merged items
          let mergedItems = {};

          response.data.categoryData.forEach(row => {
            let itemName = row.item_name;
            let quantityReceived = parseInt(row.quantity_received);

            // If the item already exists in mergedItems, add to its total
            if (mergedItems[itemName]) {
              mergedItems[itemName].total += quantityReceived;
            } else {
              // Otherwise, initialize the item
              mergedItems[itemName] = {
                item: itemName,
                balance: row.quantity,
                total: quantityReceived,
                status: ''
              };
            }
          });

          // Update status based on totals
          Object.values(mergedItems).forEach(item => {
            if (item.total === 0) {
              item.status = 'Out of Stock';
            } else if (item.total <= 300) {
              item.status = 'Low Stock';
            } else {
              item.status = 'In Stock';
            }
          });

          // Convert mergedItems object to array
          this.rows = Object.values(mergedItems);

        }).catch(error => {
          console.error('Error fetching data:', error);
        });
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
        axios.get(`https://weavemanila.optikl.ink/backend/api/verification.php?email=${this.email}`)
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
            if (this.position.toLowerCase() === 'owner'  || this.position.toLowerCase() === 'production staff' || this.position.toLowerCase() === 'warehouseman') {
              this.$router.push('/dashboard/inventory-viewpage');
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
    background-color: #755e4a
    color: #fff
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
