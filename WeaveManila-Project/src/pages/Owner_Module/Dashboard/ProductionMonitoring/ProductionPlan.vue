<template>
<SideBar />
<q-page class="bg-[#f5f5f5] ">
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
        <span class="font-bold">Production Job Order</span>
        <div class="text-[16px] text-[#999999]">Lorem Ipsum</div>
      </div>

    </div>
    <LogoutTop />
  </div>
  <div class="p-4">
    <div class="bg-white px-4 py-3 rounded h-[460px]">
      <div class='justify-end items-end flex mb-3'>
        <q-btn label='Add Plan' icon='add' @click="addPJO"/>
      </div>
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
                <q-btn icon='edit' class='bg-[#109CF1] text-white ms-1 me-1' @click='handleEdit(props.row.id, props.row.jobOrderNo, props.row.client_name, props.row.pattern, props.row.Quantity, props.row.size, props.row.order_date, props.row.commitment_date, props.row.shipment_date, props.row.clientName, props.row.size_selected, props.row.width, props.row.length )'>
                  <q-tooltip :offset="[0, 8]">Edit</q-tooltip>
                </q-btn>
              </q-td>
            </template>
        </q-table>
    </div>
  </div>
</q-page>

<q-dialog
  v-model="addPlan"
  persistent transition-show="scale" transition-hide="scale"
>
  <q-card style="width: 950px; max-width: 80vw;">
    <q-card-section class="row items-center q-pb-none">
          <div class="flex gap-2">
            <div class='p-2 border '>
              <q-icon name='group' class='text-[16px]'/>
            </div>
            <p class='text-h6'>{{ pjoIDlatest }}</p>
          </div>
          <q-space />
          <q-btn icon="close" flat round dense @click='closeModal' />
    </q-card-section>

    <q-card-section class="q-pt-none">
      <p class='text-bold'>Job Order Information</p>
      <div class='grid grid-cols-2 gap-2 mt-3'>
        <div>
          <label>Client Name</label>
          <q-input v-model='v_clientname' dense outlined/>
        </div>
        <div>
          <label>Pattern</label>
          <q-input v-model='v_pattern'  dense outlined class='bg-grey-300'/>
        </div>
        <div>
          <label>Quantity</label>
          <q-input v-model='v_quantity'  dense outlined/>
        </div>
        <div>
          <label>Size</label>
          <!-- <q-input v-model='v_size'  dense outlined/> -->
          <div class='flex gap-2 items-center'>
            <q-input v-model='v_length' dense outlined label='Length' type='number' class='w-[80px]'/>
            <p class='text-h6'>:</p>
            <q-input v-model='v_width' dense outlined type='number' label='Width' class='w-[80px]'/>
            <q-select v-model="v_size" :options="v_optionssize" dense outlined class='w-[264px]' label='Measurements'/>
          </div>
        </div>
      </div>

      <div class='font-bold text-[16px]'>Production Time Frame</div>
      <div class='grid grid-cols-2 gap-2 mt-3'>
        <div>
          <label>Order Date</label>
          <q-input v-model='v_orderdate' type='date' dense outlined/>
        </div>
        <div>
          <label>Commitment Date</label>
          <q-input v-model='v_commitment' type='date' dense outlined/>
        </div>
        <div>
          <label>Shipped Date</label>
          <q-input v-model='v_shipment' type='date' dense outlined/>
        </div>
      </div>
    </q-card-section>

    <q-card-actions align="right" class="bg-white text-teal">
        <q-btn label='Submit' class='bg-[#634832] text-white' @click='sendPjoData'/>
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
<q-dialog v-model="editDialog" persistent transition-show="scale" transition-hide="scale">
      <q-card class='w-[964px]'>
        <q-card-section class="row items-center q-pb-none">
          <div class='flex gap-2 items-center'>
            <q-icon name="group" class="w-[48px] h-[48px] text-h5 rounded drop-shadow-lg"/>
            <div class='text-h6'>
              Job Order No. {{ JobOrderNo }}
            </div>
          </div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup @click='handleClose'/>
        </q-card-section>

        <q-card-section>
          <q-form @submit='onUpdate'>
            <div class='font-bold text-[16px]'>Job Order Information</div>
            <div class='grid grid-cols-2 gap-2 mt-3'>
              <div>
                <label>Client Name</label>
                <q-input v-model='v_clientname' dense outlined/>
              </div>
              <div>
                <label>Pattern</label>
                <q-input v-model='v_pattern' dense outlined class='bg-grey-300'/>
              </div>
              <div>
                <label>Quantity</label>
                <q-input v-model='v_quantity' dense outlined/>
              </div>
              <div>
                <label>Size</label>
                <!-- <q-input v-model='v_size'  dense outlined/> -->
                <div class='flex gap-2 items-center'>
                  <q-input v-model='v_length' dense outlined type='number' class='w-[60px]'/>
                  <p class='text-h6'>:</p>
                  <q-input v-model='v_width' dense outlined type='number' class='w-[60px]'/>
                  <q-select v-model="v_size" :options="v_optionssize" dense outlined class='w-[155px]'/>
                </div>
              </div>
            </div>
            <div class='font-bold text-[16px]'>Production Time Frame</div>
            <div class='grid grid-cols-2 gap-2 mt-3'>
              <div>
                <label>Order Date</label>
                <q-input v-model='v_orderdate' type='date' dense outlined/>
              </div>
              <div>
                <label>Commitment Date</label>
                <q-input v-model='v_commitment' type='date' dense outlined/>
              </div>
              <div>
                <label>Shipped Date</label>
                <q-input v-model='v_shipment' type='date' dense outlined/>
              </div>
            </div>
            <div class='flex justify-end items-end'>
              <q-btn label='Submit' type='submit' class='bg-[#634832] text-white'/>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
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
      drawer: false,
      showMenuIcon: false,
      statusCheckTimer: null,
      toggleDrawers: true,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      OpenLogout: false,
      // New Data
      addPlan: false,
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
      selected: [],
            initialPagination: {
        page: 1,
        rowsPerPage: 10
      },
      editDialog: false,
      v_clientname: '',
      v_pattern: '',
      v_quantity: '',
      v_size: '',
      v_orderdate: '',
      v_commitment: '',
      v_shipment: '',
      v_selected: '',

      v_length: '',
      v_width: '',
      v_optionssize: ['Feet', 'Meters', 'Centimeters', 'Millimeters','Inches'],
      pjoIDlatest: '',
    };
  },
  mounted() {
    this.fetchPJOLatestID();
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
    this.fetchallPJO();
  },
  watch: {
    v_commitment(newDate) {
      if (newDate < this.v_orderdate) {
        this.v_commitment = this.v_orderdate;
        this.$q.notify({
            message: 'Commitment Date cannot be earlier than Order Date.',
            color: 'negative',
        });
      }
    },
    v_shipment(newDate) {
      if (newDate < this.v_commitment) {
        this.v_shipment = this.v_commitment;
        this.$q.notify({
            message: 'Shipped Date cannot be earlier than Commitment Date. ',
            color: 'negative',
        });
      }
    }
  },
  methods: {
    fetchPJOLatestID(){
      axios.get('https://weavemanila.optikl.ink/backend/api/ProductionMonitoring/productionplan.php')
      .then((response) => {
        const latestData = response.data.mpo;
        const latestPJO = response.data.pjoID;
        const lastTwoDigits = latestData.companyDate.slice(2, 4);
        const PjoFormat = `PJO${lastTwoDigits}-${latestPJO}`;
        this.pjoIDlatest = `PJO${lastTwoDigits}-${latestPJO}`;
      }).catch(error => {
          console.error("Error fetching PJO data:", error);
      });
    },
    sendPjoData() {
      if (!this.v_clientname || !this.v_pattern || !this.v_quantity || !this.v_size || !this.v_orderdate || !this.v_commitment || !this.v_shipment) {
        this.$q.notify({
          message: 'Please fill in all required fields.',
          color: 'negative',
        });
        return;
      }
      const formData = {
        email: this.email,
        v_clientname: this.v_clientname,
        v_pattern: this.v_pattern,
        v_quantity: this.v_quantity,
        v_orderdate: this.v_orderdate,
        v_commitment: this.v_commitment,
        v_shipment:   this.v_shipment,
        v_length: this.v_length,
        v_width: this.v_width,
        v_size: this.v_size
      }
      axios.post('https://weavemanila.optikl.ink/backend/api/ProductionMonitoring/productionplan.php', formData)
      .then((response) => {
        const Message = response.data.message;
        if(response.data.status === 'success'){
          this.$q.notify({
              message: `${Message}`,
              color: 'green',
          });
          this.fetchallPJO();
          this.addPlan = false;
          this.v_clientname = '';
          this.v_pattern = '';
          this.v_quantity = '';
          this.v_orderdate = '';
          this.v_commitment = '';
          this.v_shipment = '';
          this.v_length = '';
          this.v_width = '';
          this.v_size = '';
        }else if(response.data.status === 'fail'){
          this.$q.notify({
              message: `${Message}`,
              color: 'negative',
          });
          this.fetchallPJO();
          this.addPlan = false;
          this.v_clientname = '';
          this.v_pattern = '';
          this.v_quantity = '';
          this.v_orderdate = '';
          this.v_commitment = '';
          this.v_shipment = '';
          this.v_length = '';
          this.v_width = '';
          this.v_size = '';
        }
      }).catch(error => {
          console.error("Error fetching PJO data:", error);
      });
    },
    addPJO(){
      this.v_clientname = '';
      this.v_pattern = '';
      this.v_quantity = '';
      this.v_orderdate = '';
      this.v_commitment = '';
      this.v_shipment = '';
      this.v_length = '';
      this.v_width = '';
      this.v_size = '';
      this.addPlan = true;
    },
    closeModal(){
      this.v_clientname = '';
      this.v_pattern = '';
      this.v_quantity = '';
      this.v_orderdate = '';
      this.v_commitment = '';
      this.v_shipment = '';
      this.v_length = '';
      this.v_width = '';
      this.v_size = '';
      this.addPlan = false;
    },
    handleEdit(id, jobOrderNo, v_clientname, v_pattern, v_quantity, v_size, v_orderdate, v_commitment, v_shipment, clientname, size_select, x, y) {
      this.editDialog = true;
      // Assuming pjoNumber is a string or a number
      this.JobOrderNo = jobOrderNo;
      // Now you can use other parameters as needed
      this.v_clientname = v_clientname;
      this.v_pattern = v_pattern;
      this.v_quantity = v_quantity;
      this.v_size = size_select;
      this.v_orderdate = v_orderdate;
      this.v_commitment = v_commitment;
      this.v_shipment = v_shipment;
      this.v_selected = id;
      this.v_clientname = clientname;
      this.v_width = x;
      this.v_length = y;
    },
    onUpdate(){

      const formData = {
        v_selected: this.v_selected,
        v_clientname: this.v_clientname,
        v_pattern: this.v_pattern,
        v_quantity: this.v_quantity,
        v_orderdate: this.v_orderdate,
        v_commitment: this.v_commitment,
        v_shipment:   this.v_shipment,
        v_length: this.v_length,
        v_width: this.v_width,
        v_size: this.v_size
      }
      axios.post('https://weavemanila.optikl.ink/backend/api/ProductionMonitoring/production_job_order/pjo_query.php', formData)
      .then((response) => {
        console.log(response.data);
          const Status = response.data.status;
          const Message = response.data.message;
          if (Status === "success") {
            this.$q.notify({
                message: `${Message}`,
                color: 'green',
            });
            this.fetchallPJO();
            this.v_clientname = '';
            this.v_pattern = '';
            this.v_quantity = '';
            this.v_size = '';
            this.v_orderdate = '';
            this.v_commitment = '';
            this.v_shipment = '';
            this.v_selected = '';
            this.editDialog = false;
          }
          if (Status === "fail") {
            this.$q.notify({
              color: 'negative',
              message: `${Message} Please try again.`,
            });
          }
      }).catch(error => {
          console.error("Error fetching PJO data:", error);
      });

    },
    fetchallPJO(){
      // Define unit abbreviation mapping
      const unitAbbreviations = {
        'Feet': 'ft',
        'Meters': 'm',
        'Centimeters': 'cm',
        'Millimeters': 'mm',
        'Inches': 'in'
      };

      axios.get('https://weavemanila.optikl.ink/backend/api/ProductionMonitoring/job_order/job_order.php?type=getPJOall')
      .then((response) => {
          console.log(response.data);
          this.rows = response.data.PJOdata.map(row => {
            const sizeSelectedAbbreviated = unitAbbreviations[row.size_selected] || row.size_selected;
            const latestData = response.data.mpo;
            const latestPJO = response.data.pjoID;
            const lastTwoDigits = latestData.companyDate.slice(2, 4);
            const PjoFormat = `PJO${lastTwoDigits}-${row.pjoID}`;
              return {
                  id: row.pjoID,
                  jobOrderNo: PjoFormat,
                  jo: row.job_order_no,
                  pattern: row.design_pattern,
                  Quantity: row.quantity,
                  size: row.width + 'x' + row.length + ' ' + sizeSelectedAbbreviated,
                  size_selected: row.size_selected,
                  width: row.width,
                  length: row.length,
                  order_date: row.order_date,
                  commitment_date: row.commitment_date,
                  shipment_date: row.shipped_date,
                  clientName: row.client_name,
              };
          });
      }).catch(error => {
          console.error("Error fetching PJO data:", error);
      });

    },
    getSelectedString() {
      return `Selected ${this.selected.length} item(s)`;
    },








    // Old Data
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
          if (this.position.toLowerCase() === 'owner'  || this.position.toLowerCase() === 'production staff') {

            this.$router.push('/dashboard/productionplan-section');
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
  height: 330px

  .q-table__top,

  thead tr:first-child th
    /* bg color is important for th; just specify one */
    background-color: #fff
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
