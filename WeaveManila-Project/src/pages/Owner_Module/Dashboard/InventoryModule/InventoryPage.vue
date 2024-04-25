<template>
<SideBar />
<q-page class="bg-[#f5f5f5] ">
  <div class='flex justify-between items-center text-[30px] bg-white p-2'>
    <div class="">
      <div class="items-center flex ">
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
      <span class="font-bold">Inventory</span>
      </div>
      <div class="text-[16px]">Efficiently manage and track your stock for streamlined supply chain operations and optimized inventory.</div>
    </div>
    <LogoutTop />
  </div>

  <div class="p-4">
    <div class="p-4 overflow-y-auto overflow-x-hidden h-[500px] bg-white">
      <div class='justify-between flex'>
        <div>
          <q-input v-model='search' dense outlined label='Search...'>
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-input>
        </div>
        <div class='flex gap-3'>
          <q-btn icon="download"/>
          <q-btn icon="print"/>
          <q-btn-dropdown label="Category">
            <q-list>
              <q-item >
                <q-item-label class='cursor-pointer' @click="onItemClick(null)" >All Categories</q-item-label>
              </q-item>
              <q-item v-for="(category, index) in categories" :key="index" >
                <q-item-label class='cursor-pointer' @click="onItemClick(category.categoryID)">{{ category.title }}</q-item-label>
              </q-item>
            </q-list>
          </q-btn-dropdown>
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
        >
        <template v-slot:body-cell-product="props">
          <q-td :props="props">
            <div v-if="props.row.product && props.row.product.length > 0">
              <!-- Iterate over each product -->
              <div v-for="(product, index) in props.row.product" :key="index">
                <div v-if="product !== null">
                  <!-- Expand icon -->
                  <!-- <q-icon  name="expand_more" @click="toggleExpand(props.row.mpo_id, product)" /> -->
                  {{ product }}
                </div>
              </div>
            </div>
          </q-td>
        </template>

        <template v-slot:body-cell-qty="props">
          <q-td :props="props">
            <div v-for="qty in props.row.qty" :key="qty">{{ qty }}</div>
          </q-td>
        </template>

        <template v-slot:body-cell-qty_balance="props">
          <q-td :props="props">
            <div v-for="qty in props.row.qty_balance" :key="qty">{{ qty }}</div>
          </q-td>
        </template>

        <template v-slot:body-cell-qty_received="props">
          <q-td :props="props">
            <div v-for="qty_received in props.row.qty_received" :key="qty_received">{{ qty_received }}</div>
          </q-td>
        </template>

        <template v-slot:body-cell-status="props">
          <q-td :props="props">
            <div v-for="status in props.row.status" :key="status">
              <q-badge :color="calculateStatus(status)">
                {{ status }}
              </q-badge>
            </div>
          </q-td>
        </template>

        <template v-slot:body-cell-amount="props">
          <q-td :props="props">
            <div v-for="amount in props.row.amount" :key="amount">{{ amount }}</div>
          </q-td>
        </template>

        <template v-slot:body-cell-actions="props">
              <q-td :props="props">
                <div class="flex items-center justify-center w-[221px] gap-1">

                  <div class="bg-[#26218e] rounded text-white cursor-pointer w-[32px] h-[32px] text-[20px]">
                    <q-icon name="assignment" @click="ViewForm(props.row.mpo_id)">
                      <q-tooltip :offset="[0, 8]">View Form</q-tooltip>
                    </q-icon>
                  </div>
                  <div class="bg-[#475467] rounded text-white cursor-pointer w-[32px] h-[32px] text-[20px]">
                    <q-icon name="edit" >
                      <q-tooltip :offset="[0, 8]">Edit</q-tooltip>
                    </q-icon>
                  </div>
                  <!-- <div class="w-[32px] h-[32px] cursor-pointer text-[20px]">
                    <q-icon name="arrow_forward_ios" @click="toNextPage(props.row.mpo_id)"/>
                  </div> -->
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
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import SideBar from '../Essentials/SideBar.vue';
import LogoutTop from '../Essentials/LogoutTop.vue';
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
      addCategory: false,
      drawer: false,
      showMenuIcon: false,
      statusCheckTimer: null,
      toggleDrawers: true,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      OpenLogout: false,
      // Add DATA
      search: '',
      categories: [],
      columns: [
        { name: 'mpo_number', align: 'left', label: 'MPO No.', field: 'mpo_number', sortable: true, headerStyle: 'width: 44px;' },
        { name: 'supplier', align: 'left', label: 'Supplier', field: 'supplier', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'product', align: 'left', label: 'Product', field: 'product', sortable: true, headerStyle: 'width: 150px;' },
        { name: 'qty', align: 'left', label: 'Qty Purchased', field: 'qty', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'qty_balance', align: 'left', label: 'Qty Balance', field: 'qty_balance', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'actions', align: 'center', label: 'Actions', field: 'actions', sortable: true },
      ],

      rows: [],
    };
  },
  mounted() {
    this.fetchMPOData();
    this.fetchCategory();
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
    this.clearInventoryData();
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    onItemClick(category) {
      if (category == null) {
        this.fetchMPOData();
      } else {
        axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php?type=4&id=${category}`)
        .then(response => {
          try {
            const groupedData = response.data.categoryData.reduce((acc, row) => {
                if (!acc[row.mpoID]) {
                    acc[row.mpoID] = {
                        mpo_id: row.mpoID,
                        mpo_number: row.mpoID,
                        supplier: row.supplier_name,
                        date_purchase: row.date_purchased,
                        product: [],
                        qty: [],
                        total: [],
                        amount: [],
                        status: [],
                        qty_balance: [],
                    };
                }
                acc[row.mpoID].amount.push(row.subtotal);
                acc[row.mpoID].product.push(row.item_name);
                acc[row.mpoID].qty.push(row.quantity);


                acc[row.mpoID].qty_balance.push(row.quantity_received);

                // Calculate status based on received quantity
                let status = '';
                if (row.quantity_received === 0) {
                    status = 'Out of Stock';
                } else if (row.quantity_received  <= 300) {
                  status = 'Low Stock';
                } else  {
                    status = 'In Stock';
                }
                acc[row.mpoID].status.push(status);
                return acc;
            }, {});

            const groupedArray = Object.values(groupedData);

            // Filter out ungrouped data (where only one data point exists)
            const ungroupedData = response.data.categoryData.filter(row => !groupedData[row.mpoID]);

            // Combine grouped and ungrouped data
            const combinedData = groupedArray.concat(ungroupedData);

            this.rows = combinedData;
          } catch (error) {
            console.error('Error processing data:', error);
            this.$q.notify({
              color: 'negative',
              position: 'bottom',
              message: 'There is no data in this category.',
            });
          }
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
      }
    },
    fetchMPOData() {
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php?type=3`)
      .then(response => {
        console.log(response.data)
        const groupedData = response.data.categoryData.reduce((acc, row) => {
            if (!acc[row.mpoID]) {
                acc[row.mpoID] = {
                    mpo_id: row.mpoID,
                    mpo_number: row.mpoID,
                    supplier: row.supplier_name,
                    date_purchase: row.date_purchased,
                    product: [],
                    qty: [],
                    total: [],
                    amount: [],
                    status: [],
                    qty_balance: [],
                };
            }
            acc[row.mpoID].amount.push(row.subtotal);
            acc[row.mpoID].product.push(row.item_name);
            acc[row.mpoID].qty.push(row.quantity);


            acc[row.mpoID].qty_balance.push(row.quantity_received);

            // Calculate status based on received quantity
            let status = '';
            if (row.quantity_received === 0) {
                status = 'Out of Stock';
            } else if (row.quantity_received  <= 300) {
              status = 'Low Stock';
            } else  {
                status = 'In Stock';
            }
            acc[row.mpoID].status.push(status);
            return acc;
        }, {});

        const groupedArray = Object.values(groupedData);

        // Filter out ungrouped data (where only one data point exists)
        const ungroupedData = response.data.categoryData.filter(row => !groupedData[row.mpoID]);

        // Combine grouped and ungrouped data
        const combinedData = groupedArray.concat(ungroupedData);

        this.rows = combinedData;
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
    },
    fetchCategory() {
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=category`)
        .then(response => {
          // Assuming response.data is an array of categories
          this.categories = response.data.categoryData;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    clearInventoryData() {
      sessionStorage.removeItem('inventoryData');
    },
    onSubmit(){
      const formData = {
        title: this.title,
        procedure: this.selectedProcedure,
        description: this.description,

      }
      axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php/', formData)
      .then(response => {

        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: 'Category Added!!',
              caption: `${Message}`,
              color: 'green',
          });
          this.title = '';
          this.description = '';
          this.procedureOptions = [];
          this.addCategory = false;
          this.fetchData();
        }
        if (Status === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${Message} Please try again.`,
          });
        }

      }).catch(error => {
            console.error('Error fetching data:', error);
      });
    },

    calculateStatus(status) {
      switch (status) {
        case 'Out of Stock':
          return 'red';
        case 'Low Stock':
          return 'yellow';
        case 'On Stock':
          return 'green';
        default:
          return 'gray'
      }
    },
    isValidDate(dateString) {
      // Attempt to create a Date object from the dateString
      const date = new Date(dateString);
      // Check if the date object is valid
      // If it's an invalid date or "No Data", return false
      return !isNaN(date.getTime()) && dateString !== 'No Data';
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

            this.$router.push('/dashboard/inventory-section');
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
  },
};
</script>
