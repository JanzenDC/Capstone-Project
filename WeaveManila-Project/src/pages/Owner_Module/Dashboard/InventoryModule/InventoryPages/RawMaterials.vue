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
          <p class="font-bold text-[#755e4a]">MPO {{ mpoIDnumber }}</p>
          <p class="text-[16px] text-[#89909e]">Inventory / Raw Materials / <span class="text-black">MPO {{ mpoIDnumber }}</span></p>
        </div>
      </div>
    <LogoutTop />
  </div>
  <div class="p-4">
    <div class="flex mt-3">
      <router-link to="rawmaterials-section">
        <div class="flex bg-white w-[128px] border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">

          <q-icon name="library_books"/>
          <p>Details</p>
        </div>
      </router-link>
      <router-link to="segregate-section">
          <div class="flex w-[135px] text-[#89909e] border-t-2 border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="list"/>
            <p>Segregate</p>
          </div>
      </router-link>
      <router-link to="issuance-section">
          <div class="flex w-[128px] text-[#89909e] border-t-2 border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="group"/> 
            <p>Issuance</p>
          </div>
      </router-link>
    </div>
    <div class="w-full bg-white p-4  h-[470px]">
      <div class="flex justify-end items-end gap-4">
        <q-btn icon="download" />
        <q-btn icon="print" />
        <q-btn icon="refresh" />
      </div>
      <q-separator class="mt-9 "/>
      <div class="overflow-y-auto overflow-x-hidden h-[350px] mt-3">
        <div class="text-[16px] mt-3">
          <p> Date Purchased: {{ date_purchased }}</p>
          <p> Supplier: {{ supplier_name }}</p>
          <p> Delivery Charge: {{ delivery_charge }}</p>
          <p> Discount: {{ discount }}</p>
          <p> Other Cost: {{ other_costs }}</p>
          <p> <span class="font-bold">Total Amount:</span>{{ total_amount }}</p>
        </div>
        <div class="text-[16px] mt-3 font-bold">
          Purchase Details
        </div>
        <div class="q-pa-md">
          <q-table
            :rows="rows"
            :columns="columns"
            row-key="name"
          >
          <template v-slot:body-cell-status="props">
            <q-td :props="props">
              <span v-if="props.row.status === 2" class="text-green-600 p-2 rounded-full bg-green-300">
                ● In Stock
              </span>
              <span v-else-if="props.row.status === 0" class="text-red-600 p-2 rounded-full bg-red-300">
                ● Out of stock
              </span>
              <span v-else-if="props.row.status === 1" class="text-yellow-600 p-2 rounded-full bg-yellow-300">
                ● Low Stock
              </span>
            </q-td>
          </template>
          </q-table>

        </div>
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
import LogoutTop from '../../Essentials/LogoutTop.vue';
import SideBar from '../../Essentials/SideBar.vue';
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
      // Another Data
      mpoSelect: '',
      columns: [
        { name: 'product', align: 'left', label: 'Product', field: 'product', sortable: true, headerStyle: 'width: 44px;' },
        { name: 'qtypurchased', align: 'left', label: 'Qty Purchased', field: 'qtypurchased', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'product_cost', align: 'left', label: 'Product Cost', field: 'product_cost', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'qtyreceived', align: 'left', label: 'Qty Received', field: 'qtyreceived', sortable: true, headerStyle: 'width: 150px;' },
        { name: 'qtybalance', align: 'left', label: 'Qty Balance', field: 'qtybalance', sortable: true, headerStyle: 'width: 150px;' },
        { name: 'received_date', align: 'left', label: 'Received Date', field: 'received_date', sortable: true, headerStyle: 'width: 150px;' },
        { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true, headerStyle: 'width: 80px;' }
      ],
      rows: [],
      mpoIDnumber: '',
      date_purchased: '',
      delivery_charge: '',
      discount: '',
      other_costs: '',
      total_amount: '',
      supplier_name: '',
    };
  },
  mounted() {
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 50 * 1000);
    this.loadFetchData(); //uncomment this
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    loadFetchData() {
      const MPOData = SessionStorage.getItem('MPOData');
      if (MPOData) {
        try {
          const mpoInfo = JSON.parse(MPOData); // Parse MPOData

          this.mpoIDnumber = mpoInfo.mpoID;
          const datePurchased = new Date(mpoInfo.date_purchased);
          const day = datePurchased.getDate();
          const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
          const monthName = monthNames[datePurchased.getMonth()];
          const year = datePurchased.getFullYear();
          this.date_purchased = `${day} ${monthName} ${year}`;
          this.supplier_name = mpoInfo.supplier_name;
          this.total_amount = mpoInfo.total_amount;
          this.delivery_charge = mpoInfo.delivery_charge;
          this.discount = mpoInfo.discount;
          this.other_costs = mpoInfo.other_costs;

          axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_details.php?targetdata=rawmats&targetdatas=${this.mpoIDnumber}`)
          .then(response => {
            console.log(response.data.information);
            this.rows = response.data.information.map(row => {
              let status = '';
              if (row.quantity_received === row.quantity_balance || row.quantity_received > 300) {
                  status = 2;
              } else if (row.quantity_balance === 0) {
                  status = 0;
              } else if (row.quantity_received < 300 || row.quantity_received > row.quantity_balance / 2) {
                  status = 1;
              }
              return {
                product: row.item_name,
                qtypurchased: row.quantity,
                product_cost: row.subtotal,
                qtyreceived: row.quantity_received,
                qtybalance: row.quantity_balance,
                received_date: row.date_received,
                status: status
              };
            })
          }).catch(error => {
              console.error('Error fetching data:', error);
          });


        } catch (error) {
          console.log('Error parsing user data:', error);
          this.$q.notify({
            type: 'negative',
            message: 'Error loading user data. Please try again.',
          });
          this.$router.push('/dashboard/mpo-section');
          SessionStorage.removeItem('MPOData');
          SessionStorage.removeItem('RetrieveData');
        }
      } else {
        this.$router.push('/dashboard/mpo-section');
        SessionStorage.removeItem('MPOData');
        SessionStorage.removeItem('RetrieveData');
      }
    },



    onMainDashboard(){
      this.$router.push('/dashboard/main-dashboard');
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
          if (this.position.toLowerCase() === 'owner'  || this.position.toLowerCase() === 'production staff' || this.position.toLowerCase() === 'warehouseman') {
            this.$router.push('/dashboard/rawmaterials-section');
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

