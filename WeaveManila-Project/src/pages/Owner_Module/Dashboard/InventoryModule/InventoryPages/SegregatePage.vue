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
          src="../../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[50px] md:w-[60px]"
        />
      </div>
      <div class=" items-center flex justify-center" v-if="drawerWidth <= 80">
        <q-img
          src="../../../../../assets/favicon-128x128.png"
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
        <div class="flex items-center cursor-pointer gap-2 justify-between">
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

      <li class="py-[10px] px-[20px]" @click="toggleProduction">
        <div class="flex items-center cursor-pointer gap-2 justify-between">
          <div>
            <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
          </div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="productionVisible">
          <router-link to="/dashboard/productionplan-section">
            <li class="py-[2px] px-[40px] mt-3">Production Plan</li>
          </router-link>
        </ul>
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
      <li class="py-[10px] px-[20px]" v-if="isAdmin === 1">
        <div class="flex items-center">
          <router-link to="/dashboard/backup-section">
            <q-icon name="backup" class="mr-2"/> <span >Data Backup</span>
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
          <div @click="OpenLogout = true">
            <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
          </div>
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
        <div class="flex items-center cursor-pointer gap-2 justify-between">
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
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="backup"/>
        </div>
      </li>
      <li class="mt-auto py-[10px]">
          <div class="flex justify-center ">
          <div @click="OpenLogout = true">
            <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
          </div>
          </div>
      </li>
  </ul>
</q-drawer>
<q-page class="bg-[#f5f5f5]">
    <div class="text-[30px] bg-white p-2">
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
      <div class="">
        <p class="font-bold text-[#755e4a]">MPO {{ mpoIDnumber }}</p>
          <p class="text-[16px] text-[#89909e]">Inventory / Raw Materials / <span class="text-black">MPO {{ mpoIDnumber }}</span></p>
      </div>
    </div>
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
    <div class="w-full bg-white p-4  h-[390px]">
      <div class="flex justify-between">
        <div class='flex gap-4'>
          <p>Quantity In: {{ qty_in }}</p>
          <p>Quantity Balance: {{ qty_bal }}</p>
        </div>
        <div class='flex gap-4'>
          <q-btn icon="download" />
          <q-btn icon="print" />
          <q-btn-dropdown label="Items">
            <q-list>
              <q-item v-for="(category, index) in categories" :key="index" >
                <q-item-label class='cursor-pointer' @click="onItemClick(category.baseID)">{{ category.item_name }}</q-item-label>
              </q-item>
            </q-list>
          </q-btn-dropdown>
          <q-btn icon="add" label='Issue' class='bg-[#634832] text-white' @click='OpenIssue'/>
        </div>


      </div>
      <q-separator class="mt-9 "/>
      <div class="overflow-y-auto overflow-x-hidden h-[300px] mt-3">

        <div v-for="item in items" :key="item.id" class="gap-2 mt-3">
          <div class='flex items-center gap-2 mt-2'>
            <p>Product
              <span class='text-red-600'>*</span>
            </p>
            <q-input dense outlined v-model="item.value"/>
            
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
        </div>
        <q-btn label='Add Product' class='bg-[#634832] text-white mt-4'/>
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
      <p>Issuance</p>
      <div class='grid grid-cols-2 gap-2'>
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
      <p>Received</p>
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
      
        <template v-slot:header-cell-action="props">
          <q-th :props="props">
            <q-icon name="add" size="1.5em" class='bg-yellow-600 text-white' @click="addData"/>
          </q-th>
        </template>

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
      <q-btn flat label="Submit" class='bg-[#634832] text-white' @click="submitData"/>
    </q-card-actions>
  </q-card>
</q-dialog>


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

  export default {
    setup() {
      const $q = useQuasar();
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
        columns: [
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
        selectedBaseID: '',

        openModal2: false,
        segregatorName: '',
        qqty_raw: '',
        qqty_recieved: '',
        wwaste_gumon: '',
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
    watch: {
      rows_second: {
        deep: true,
        handler() {
          this.calculateTotals();
        },
      },
      qty_raw_issuance(newValue) {
        if (newValue > this.qty_bal) {
          // Reset qty_raw_issuance to the maximum allowed value if it exceeds qty_in
          this.qty_raw_issuance = this.qty_bal;
          this.$q.notify({
            type: 'negative',
            message: `Qty Raw Issuance cannot exceed ${this.qty_bal}`
          });
        } else {
            this.qty_raw_issuance = newValue;
        }
      },
      qty_received(newValue) {
        if (newValue > this.qty_raw_issuance) {
          this.qty_received = this.qty_raw_issuance;
          this.$q.notify({
            type: 'negative',
            message: `Qty Received exceed ${this.qty_raw_issuance}`
          });
        } else {
            this.qty_received = newValue;
        }

      },
      vWaste(newValue) {
        if (newValue > this.qty_received) {
          this.vWaste = this.qty_received;
          this.$q.notify({
            type: 'negative',
            message: `Waste cannot exceed ${this.qty_received}`
          });
        } else {
            this.vWaste = newValue;
        }
      }
    },
    methods: {
      submitData() {
        const formData = new FormData();
        const target = 4;
        formData.append('type', target);
        formData.append('segregatorName', this.segregatorName);
        this.rows_second.forEach(row => {
            const segregateData = {
              date_issuance: row.product.label,
              qty_raw: row.description,
              qty_received: row.quantity,
              waste_gumon: row.unit,
            };
            formData.append('products[]', JSON.stringify(segregateData));
        });
        this.openModal2 = false;
        axios.post('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/Weaver_Queries/segregator.php/', formData)
        .then(response => {
        }).catch(error => {
              console.error('Error fetching data:', error);
        });
      },
      calculateTotals() {
        this.qqty_raw = this.rows_second.reduce((total, row) => parseFloat(row.qty_raw) - total, 0);
        this.qqty_received = this.rows_second.reduce((total, row) => parseFloat(row.qty_received)  - total, 0);
        this.wwaste_gumon = this.rows_second.reduce((total, row) => parseFloat(row.waste_gumon)  - total, 0);
      },
      addData() {

        this.rows_second.push({
          date_issuance: '', 
          qty_raw: '',
          qty_received: '',
          waste_gumon: '',
          action: ''
        });
      },
      handleVisibilityClick(item, rowData) {
        // Log the clicked item and row data
        console.log(rowData);
        this.segregatorName = rowData.segregator;
        this.openModal2 = true;
        axios.get(`http://localhost/Capstone-Project/backend/api/ProductionMonitoring/Weaver_Queries/segregator.php?get=onesegregator&id=${rowData.segregateID}`)
        .then(response => {
          console.log(response.data.mpoSeg)

          this.qqty_raw = response.data.mpoSeg.qty_raw_for_issuance;
           this.qqty_recieved = response.data.mpoSeg.qty_for_received_taknis;
           this.wwaste_gumon = response.data.mpoSeg.waste_gumon_for_received_taknis;
          this.rows_second = response.data.segregatorData.map(row => {
            return {
              date_issuance: row.date_issuance,
              qty_raw: row.qty_issued,
              qty_received: row.qty_received,
              waste_gumon: row.waste_gumon,
            }
          });
        }).catch(error => {
              console.error('Error fetching data:', error);
        });
      },
      submitForm() {
        if (!this.selectSegregator || !this.vData || !this.qty_raw_issuance || !this.qty_received || !this.vWaste) {
          this.$q.notify({
            type: 'negative',
            message: 'All fields are required'
          });
          return;
        }
        const calc1 = parseFloat(this.qty_received) + parseFloat(this.vWaste);
        const calc2 = parseFloat(this.qty_raw_issuance) - calc1;

        const calc3 = parseFloat(this.qty_bal) - parseFloat(this.qty_raw_issuance);
        const formData = {
          selectedBaseID: this.selectedBaseID,
          selectSegregator: this.selectSegregator.label,
          vData: this.vData,
          qty_raw_issuance: this.qty_raw_issuance,
          qty_received: this.qty_received,
          vWaste: this.vWaste,
          mpobalance: calc2,
          quantitybal: calc3,
          type: 3,
        }
        axios.post('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/Weaver_Queries/segregator.php/', formData)
        .then(response => {
          console.log(response.data)
          const Status = response.data.status;
          const Message = response.data.message;
          if (Status === "success") {
            this.$q.notify({
                message: `${Message}`,
                color: 'green',
            });
            this.loadFetchData();
            this.IssueDialog = false;
          }
          if (Status === "fail") {
              this.$q.notify({
                  color: 'negative',
                  message: `${Message} Please try again.`,
              });
              this.IssueDialog = false;
          }
        }).catch(error => {
              console.error('Error fetching data:', error);
        });
      },
      OpenIssue(){
        this.IssueDialog = true;
      },
      loadWeaverData(){
        axios.get(`http://localhost/Capstone-Project/backend/api/ProductionMonitoring/Weaver_Queries/segregator.php?get=segregator`)
        .then(response => {
          this.segOptions = response.data.segregatorData.map(segregator => ({
            value: segregator.segregatorID, // Assuming segregatorID is the value you want to use
            label: segregator.segregatorFname + ' ' + segregator.segregatorLname // Combine first name and last name as label
          }));

        }).catch(error => {
              console.error('Error fetching data:', error);
        });
      },
      onItemClick(event){
        console.log(event);
        axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_details.php?targetdata=onedata&targetdatas=${event}`)
            .then(response => {
              console.log(response.data);
              this.selectedBaseID = event;
              this.qty_in = response.data.information[0].quantity;
              console.log(response.data.information)
              this.qty_bal = response.data.information[0].quantity_balance;
              this.items = response.data.information.map(category => ({
                  value: category.item_name,
                  base: category.baseID,
                  rows: response.data.information2
                      .filter(category2 => category2.baseID === category.baseID) // Filter by matching baseID
                      .map(category2 => ({
                          segregateID: category2.segregateID,
                          base: category2.baseID,
                          segregator: category2.segregator,
                          date: category2.date,
                          qty_raw: category2.qty_raw_for_issuance,
                          qty_received: category2.qty_for_received_taknis,
                          waste_gumon: category2.waste_gumon_for_received_taknis,
                          balance: category2.balance_for_received_taknis,
                          // action: category2.action,
                      }))
              }));
            }).catch(error => {
                console.error('Error fetching data:', error);
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

            axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_details.php?targetdata=moredata&targetdatas=${this.mpoIDnumber}`)
            .then(response => {
              console.log(response.data);
              // Populate items array from the 'information' array
              this.selectedBaseID = response.data.information[0].baseID;
              this.categories = response.data.information3;
              this.qty_in = response.data.information[0].quantity;
              console.log(this.selectedBaseID)
              this.qty_bal = response.data.information[0].quantity_balance;
              this.items = response.data.information.map(category => ({
                  value: category.item_name,
                  base: category.baseID,
                  rows: response.data.information2
                      .filter(category2 => category2.baseID === category.baseID) // Filter by matching baseID
                      .map(category2 => ({
                          segregateID: category2.segregateID,
                          base: category2.baseID,
                          segregator: category2.segregator,
                          date: category2.date,
                          qty_raw: category2.qty_raw_for_issuance,
                          qty_received: category2.qty_for_received_taknis,
                          waste_gumon: category2.waste_gumon_for_received_taknis,
                          balance: category2.balance_for_received_taknis,
                          // action: category2.action,
                      }))
              }));
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
            if (this.position.toLowerCase() === 'owner') {

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

