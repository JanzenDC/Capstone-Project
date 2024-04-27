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
      <div class="flex bg-white w-[135px] border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="list"/>
          <p>Segregate</p>
        </div>
    </router-link>
    <router-link to="">
        <div class="flex w-[128px] text-[#89909e] border-t-2 border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="group"/>
          <p>Issuance</p>
        </div>
    </router-link>
  </div>
  <div class="w-full bg-white p-4  h-[450px]">
    <div class="flex justify-between">
      <div class='flex gap-4'>
        <!-- <p>Quantity In: {{ qty_in }}</p>
        <p>Quantity Balance: {{ qty_bal }}</p> -->
      </div>
      <div class='flex gap-4'>
        <q-btn icon="download" />
        <q-btn icon="print" />
        <q-btn label='Issue' class='bg-[#634832] text-white' @click='OpenIssue'/>
        <q-btn label='Receive' class='bg-[#634832] text-white' @click='ReceiveModal'/>

      </div>


    </div>
    <q-separator class="mt-5"/>
    <div class="overflow-y-auto overflow-x-hidden h-[390px] mt-3">
      <div>
        <q-select dense outlined v-model="selectProduct" :options="optionssss" class='w-[180px] mb-3'/>
        <p>Quantity In: {{ qty_in }}</p>
        <p>Quantity Balance: {{ qty_bal }}</p>
      </div>
      <div>
        <q-table :rows="rows" :columns="columns" class='mt-2'>
          <template v-slot:body-cell-action="props">
            <q-td :props="props">
              <q-icon name='visibility' class='text-h6 text-black' @click="handleVisibilityClick(props.row)">
                <q-tooltip :offset="[0, 8]">View</q-tooltip>
              </q-icon>
            </q-td>
          </template>

          <template v-slot:body-cell-balance="props">
            <q-td :props="props">
              {{ calculateBalance(props.row) }}
            </q-td>
          </template>
        </q-table>

        <q-table
          class="mt-8"
          flat bordered
          :rows="rows_third"
          :columns="columns_third"
        >
          <template v-slot:body-cell-qty_bal_received="props">
            <q-td :props="props">
              {{ calculateBalances(props.row) }}
            </q-td>
          </template>
      </q-table>
      </div>
      <!-- <div v-for="item in items" :key="item.id" class="gap-2 mt-3">
        <div class='flex items-center gap-2 mt-2'>
          <p>Product
            <span class='text-red-600'>*</span>
          </p>
          <q-select dense outlined v-model="item.value" :options="optionssss"/>

        </div>
        <q-table :rows="item.rows" :columns="columns" class='mt-2'>
          <template v-slot:body-cell-action="props">
            <q-td :props="props">
              <q-icon name='visibility' class='text-h6 text-black' @click="handleVisibilityClick(item, props.row)">
                <q-tooltip :offset="[0, 8]">View</q-tooltip>
              </q-icon>

            </q-td>
          </template>
        </q-table>
      </div> -->
    </div>


  </div>
</div>


</q-page>

<q-dialog
v-model="IssueDialog"
>
<q-card style="width: 500px; max-width: 80vw;">
  <q-card-section class="row items-center q-pb-none">
        <div class="text-h6">Issuance</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

  <q-card-section class="q-pt-none">
    <p class='font-bold'>Issuance</p>
    <div class='grid grid-cols-2 gap-2'>
      <div>Item
        <q-input dense outlined v-model='selectItem' disabled/>
      </div>
      <div>Process
        <q-select dense outlined v-model='selectProcess' :options='segProcess'/>
      </div>
      <div v-if="selectProcess === 'Twine'">
        Twine
        <q-select dense outlined v-model='selectTwine' :options='segTwine'/>
      </div>
      <div>Segregator
        <q-select dense outlined v-model='selectSegregator' :options='segOptions'/>
      </div>
      <div>Date
        <q-input type='date' dense outlined v-model='vData'/>
      </div>
      <div>Quantity Raw Issuance
        <q-input type='number' dense outlined v-model='qty_raw_issuance'/>
      </div>
    </div>
    <p class='font-bold mt-3'>Received</p>
    <div class='grid grid-cols-2 gap-2'>
      <div>Qty Received
        <q-input type='number' dense outlined v-model='qty_received'/>
      </div>
      <div>Waste/Gumon
        <q-input type='number' dense outlined v-model='vWaste'/>
      </div>
    </div>
  </q-card-section>

  <q-card-actions align="right" class="bg-white text-teal">
    <q-btn flat label="Submit" class='bg-[#634832] text-white' @click="submitForm"/>
  </q-card-actions>
</q-card>
</q-dialog>

<q-dialog
v-model="openModal2"
>
<q-card style="width: 700px; max-width: 80vw;">
  <q-card-section>
    <div class="text-h6">{{ segregatorName }}</div>
  </q-card-section>
  <q-card-section class="q-pt-none">
    <q-table
      class="my-sticky-header-table"
      flat bordered
      :rows="rows_second"
      :columns="columns_second"
    >


      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="date_issuance" :props="props">
            {{ props.row.date_issuance }}
            <q-popup-edit v-model="props.row.date_issuance" v-slot="scope">
              <q-input v-model="scope.value" dense autofocus @keyup.enter="scope.set" type='date' />
            </q-popup-edit>
          </q-td>
          <q-td key="qty_raw" :props="props">
            <q-input
              v-model.number="props.row.qty_raw"
              input-class="text-center"
              type="number"
              dense
              borderless
            />
          </q-td>
          <q-td key="qty_received" :props="props">
            <q-input
              v-model.number="props.row.qty_received"
              input-class="text-center"
              type="number"
              dense
              borderless
            />
          </q-td>
          <q-td key="waste_gumon" :props="props">
            <q-input
              v-model.number="props.row.waste_gumon"
              input-class="text-center"
              type="number"
              dense
              borderless
            />
          </q-td>
          <q-td key="action" :props="props">
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </q-card-section>

  <q-card-actions align="right" class="bg-white text-teal">
    <q-btn flat label="Close" class='bg-[#634832] text-white' v-close-popup/>
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
      IssueDialog: false,
      qty_in: '',
      qty_bal: '',
      mpoSelect: '',
      columns_third: [
      { name: 'process', align: 'left', label: 'Process', field: 'process', sortable: true,},
        { name: 'qty_raw_bal', align: 'left', label: 'Qty Raw Issued', field: 'qty_raw_bal', sortable: true,},
        { name: 'qty_received', align: 'left', label: 'Qty Received', field: 'qty_received', sortable: true,},
        { name: 'waste_gumon', align: 'left', label: 'Waste / Gumon', field: 'waste_gumon', sortable: true,},
        { name: 'qty_bal_received', align: 'left', label: 'Qty Bal Received', field: 'qty_bal_received', sortable: true,},
      ],
      rows_third: [],
      columns: [
      { name: 'process', align: 'left', label: 'Process', field: 'process', sortable: true,},
      { name: 'segregator', align: 'left', label: 'Segregator', field: 'segregator', sortable: true,},
        { name: 'date', align: 'left', label: 'Latest date of issuance', field: 'date', sortable: true, },
        { name: 'qty_raw', align: 'left', label: 'Qty Raw Issued', field: 'qty_raw', sortable: true,},
        { name: 'qty_received', align: 'left', label: 'Qty Received', field: 'qty_received', sortable: true,},
        { name: 'waste_gumon', align: 'left', label: 'Waste / Gumon', field: 'waste_gumon', sortable: true,},
        { name: 'balance', align: 'left', label: 'Qty Balance', field: 'balance', sortable: true,},
        { name: 'action', align: 'center', label: 'Actions', field: 'action'},
      ],
      rows: [],
      columns_second: [
      { name: 'date_issuance', align: 'left', label: 'Date Issuance', field: 'date_issuance', sortable: true,},
        { name: 'qty_raw', align: 'left', label: 'Qty Raw Issued', field: 'qty_raw', sortable: true,},
        { name: 'qty_received', align: 'left', label: 'Qty Received', field: 'qty_received', sortable: true,},
        { name: 'waste_gumon', align: 'left', label: 'Waste / Gumon', field: 'waste_gumon', sortable: true,},
        { name: 'action', align: 'center', label: '', field: 'action'},
      ],
      rows_second: [],
      mpoIDnumber: '',
      items: [],
      ShowFolder: false,
      // HOLDING THE DATA WHEN CLICKING THE FOLDER
      selectedID: '',
      selectedIDName: '',
      selected_Quantity: '',
      totalBalance: 0,
      totalBalanceRaw: 0,
      updatedBalance: 0,
      stored_Variable: 0,

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


      vWaste: '',
      qty_received: '',
      vData: '',
      selectSegregator: '',
      selectedBaseID: 0,

      openModal2: false,
      segregatorName: '',
      qqty_raw: '',
      qqty_recieved: '',
      wwaste_gumon: '',


      selectProduct: '',
      optionssss: [],
      selectItem: '',
      selectProcess: '',
      segTwine: '',
      segProcess: ['Taknis', 'Braided', 'Twine']
    };
  },
  
  mounted() {
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 50 * 1000);
    this.loadFetchData(); //uncomment this
    this.loadWeaverData();
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

          axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_details.php?targetdata=moredata&targetdatas=${this.mpoIDnumber}`)
          .then(response => {
            console.log(response.data)
            this.selectedBaseID = response.data.information[0].baseID;
            this.selectItem = response.data.information[0].item_name;

            this.categories = response.data.information3;
            this.selectProduct = response.data.information[0].item_name;
            this.optionssss = response.data.information4.map(category => ({
                label: category.item_name,
                value: category.baseID
            }));

            this.qty_in = response.data.information[0].quantity;
            this.qty_bal = response.data.information[0].quantity_balance;

            this.rows = response.data.information2.map(row => {
                return {
                  segregateID: row.segID,
                  base: row.baseID,
                  process: row.process,
                  segregator: row.segregatorName,
                  date: row.date_issuance,
                  qty_raw: row.total_qty_issued,
                  qty_received: row.total_qty_received,
                  waste_gumon: row.total_waste_gumon,
                  // balance: row.balance_for_received_taknis,
                }
            });
            this.rows_third = response.data.information5.map(row => {
              return {
                  segreID: row.segreID,
                  base: row.baseID,
                  process: row.	process,
                  qty_raw_bal: row.total_qty_issued,
                  qty_received: row.total_qty_received,
                  waste_gumon: row.total_waste_gumon,
                  // qty_bal_received: row.qty_received,
                }
            });
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
            this.$router.push('/dashboard/segregate-section');
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

