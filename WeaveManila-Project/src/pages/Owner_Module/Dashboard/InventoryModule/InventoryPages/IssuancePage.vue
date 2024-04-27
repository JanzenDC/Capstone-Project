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
          <p class="font-bold text-[#755e4a]">MPO {{ mpoIDnumber }}</p>
          <p class="text-[16px] text-[#89909e]">Inventory / Raw Materials / <span class="text-black">MPO {{ mpoIDnumber }}</span></p>
        </div>
      </div>
    <LogoutTop />
</div>
<div class="p-4">
  <div class="flex mt-3">
    <router-link to="rawmaterials-section">
      <div class="flex w-[135px] text-[#89909e] border-t-2 border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
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
        <div class="flex bg-white w-[135px] border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="group"/>
          <p>Issuance</p>
        </div>
    </router-link>
  </div>
  <div class="w-full bg-white p-4  h-[450px]">
      <q-table
        class="my-sticky-header-table"
        dense bordered
        :rows="rows"
        :columns="columns"
        row-key="pjoID"
        :pagination="initialPagination"
      >
      <template v-slot:body-cell-action="props">
        <q-td :props="props">
          <q-icon name='visibility' class='text-h6 text-black'>
            <q-tooltip :offset="[0, 8]">View</q-tooltip>
          </q-icon>
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
import LogoutTop from '../../Essentials/LogoutTop.vue';
import SideBar from '../../Essentials/SideBar.vue';
  export default {
    components: {
    SideBar,
    LogoutTop
  },
  data() {
    return {
      initialPagination: {
        page: 1,
        rowsPerPage: 10
      },
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
      IssueDialog: false,
      qty_in: '',
      qty_bal: '',
      mpoSelect: '',

      columns: [
        {name: 'jobOrderNo', label: 'Job Order No.', field: 'jobOrderNo', sortable: true},
        {name: 'clientName', label: 'Client Name', field: 'clientName', sortable: true},
        {name: 'pattern', label: 'Pattern', field: 'pattern', sortable: true},
        {name: 'Quantity', label: 'Quantity', field: 'Quantity', sortable: true},
        {name: 'size', label: 'Size', field: 'size', sortable: true},
        {name: 'order_date', label: 'Order Date', field: 'order_date', sortable: true},
        {name: 'commitment_date', label: 'Commitment Date', field: 'commitment_date', sortable: true},
        {name: 'shipment_date', label: 'Shipped Date', field: 'shipment_date', sortable: true},
        {name: 'edited', label: 'Edited', field: 'edited', },
        {name: 'action', label: 'Action', field: 'action', },
      ],
      rows: [],

      mpoIDnumber: '',
      items: [],
      ShowFolder: false,


      newRow: {
        date: '',
        segregator: '',
        qty_raw: '',
        qty_received: '',
        waste_gumon: ''
      },
      categories: [],
      qty_raw_issuance: '',
      segOptions: [],


    };
  },
  
  mounted() {
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 50 * 1000);
    this.loadFetchData(); //uncomment this
    this.fetchallPJO();
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },

  methods: {
    fetchallPJO(){
      // Define unit abbreviation mapping
      const unitAbbreviations = {
        'Feet': 'ft',
        'Meters': 'm',
        'Centimeters': 'cm',
        'Millimeters': 'mm',
        'Inches': 'in'
      };

      axios.get('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/job_order/job_order.php?type=getPJOall')
      .then((response) => {
          console.log(response.data);
          this.rows = response.data.PJOdata.map(row => {
            const sizeSelectedAbbreviated = unitAbbreviations[row.size_selected] || row.size_selected;
            const latestData = response.data.mpo;
            const latestPJO = response.data.pjoID;
            const lastTwoDigits = latestData.companyDate.slice(2, 4);
            const PjoFormat = `PJO${lastTwoDigits}-${row.pjoID}`;
            let lengthInInches;
            switch (sizeSelectedAbbreviated) {
                case 'ft':
                    lengthInInches = row.length * 12; // 1 foot = 12 inches
                    break;
                case 'm':
                    lengthInInches = row.length * 39.3701; // 1 meter = 39.3701 inches
                    break;
                case 'cm':
                    lengthInInches = row.length * 0.393701; // 1 centimeter = 0.393701 inches
                    break;
                case 'mm':
                    lengthInInches = row.length * 0.0393701; // 1 millimeter = 0.0393701 inches
                    break;
                case 'in':
                    lengthInInches = row.length; // Already in inches
                    break;
                default:
                    lengthInInches = row.length; // If size_selected is not recognized, keep as it is
            }

            const value = lengthInInches / row.qouta;
            let value2 = value - row.total_output_sum;
            if (isNaN(value2)) {
                value2 = '0'; // If value2 is NaN, make it 0
            }

            let status;
            if (2 === row.status) {
                status = 'Done';
            } else if (1 === row.status) {
                status = 'Ongoing';
            } else if (0 === row.status){
                status = 'Pending';
            }
              return {
                id: row.pjoID,
                // jobOrder: PjoFormat,
                commitmentDate: row.commitment_date,
                jobOrderNo: PjoFormat,
                weaver: row.endorse,
                size: row.width + 'x' + row.length + ' ' + sizeSelectedAbbreviated,
                total_output: row.total_output_sum,
                balance: value2,
                checked_by: row.checked_by,
                status: status
              };
          });
      }).catch(error => {
          console.error("Error fetching PJO data:", error);
      });

    },


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

          // axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_details.php?targetdata=moredata&targetdatas=${this.mpoIDnumber}`)
          // .then(response => {
          //   console.log(response.data)
          //   this.selectedBaseID = response.data.information[0].baseID;
          //   this.selectItem = response.data.information[0].item_name;

          //   this.categories = response.data.information3;
          //   this.selectProduct = response.data.information[0].item_name;
          //   this.optionssss = response.data.information4.map(category => ({
          //       label: category.item_name,
          //       value: category.baseID
          //   }));

          //   this.qty_in = response.data.information[0].quantity;
          //   this.qty_bal = response.data.information[0].quantity_balance;

          //   // this.rows = response.data.information2.map(row => {
          //   //     return {
          //   //       segregateID: row.segID,
          //   //       base: row.baseID,
          //   //       process: row.process,
          //   //       segregator: row.segregatorName,
          //   //       date: row.date_issuance,
          //   //       qty_raw: row.total_qty_issued,
          //   //       qty_received: row.total_qty_received,
          //   //       waste_gumon: row.total_waste_gumon,
          //   //       // balance: row.balance_for_received_taknis,
          //   //     }
          //   // });
          //   // this.rows_third = response.data.information5.map(row => {
          //   //   return {
          //   //       segreID: row.segreID,
          //   //       base: row.baseID,
          //   //       process: row.	process,
          //   //       qty_raw_bal: row.total_qty_issued,
          //   //       qty_received: row.total_qty_received,
          //   //       waste_gumon: row.total_waste_gumon,
          //   //       // qty_bal_received: row.qty_received,
          //   //     }
          //   // });
          // }).catch(error => {
          //     console.error('Error fetching data:', error);
          // });


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
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
    },
    toggleProduction(){
      this.productionVisible = !this.productionVisible;
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
            this.$router.push('/dashboard/issuance-section');
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

