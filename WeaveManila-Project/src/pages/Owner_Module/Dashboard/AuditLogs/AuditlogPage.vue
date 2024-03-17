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

      <li class="py-[10px] px-[20px]" @click="toggleProduction">
        <div class="flex items-center gap-2 justify-between">
          <div>
            <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
          </div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="productionVisible">
          <router-link to="/dashboard/productionplan-section">
            <li class="py-[2px] px-[40px] mt-3">Production Plan</li>
          </router-link>
          <router-link to="/dashboard/joborder-section">
            <li class="px-[40px] mt-3">Job Order</li>
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
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="backup"/>
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
  <div class="flex justify-between items-center p-2 bg-white">
    <div class="text-[30px]">
      <div class="items-center flex">
        <!-- First version of menu icon -->
        <q-icon
          name="menu"
          v-if="showMenuIcon"
          @click="toggleDrawer"
          class="cursor-pointer"
        />
        <!-- Second version of menu icon for smaller screens -->
        <q-icon
          name="menu"
          v-if="!showMenuIcon"
          @click="toggleDrawer"
          class="cursor-pointer max-[1020px]:flex min-[1020px]:hidden"
        />
        <span class="font-bold">Audit Logs</span>
      </div>
      <div class="text-[16px]">This section serves as a record of events and actions within a system.</div>
    </div>
  </div>
  <div class="p-4">
    <div class="flex items-end justify-end mt-6">
      <div class="flex gap-2 items-center">
          <q-input
          v-model="searchInput"
          outlined
          dense
          placeholder="Search..."
          >
          <template v-slot:prepend>
            <q-icon name="search"/>
          </template>
          </q-input>
        <q-btn @click="openModifyModal" label="Filter" class="h-5">
        <q-icon
          :name="arrowDirection_1 ? 'arrow_drop_up' : 'arrow_drop_down'"
          class="text-[25px] cursor-pointer"
        />
        </q-btn>
      </div>
    </div>
    <div class="fixed right-12 top-[200px] transform bg-white z-50 rounded-md border border-gray-500" style="max-width: 350px" v-if="showModifyModal">
      <q-form @submit="onSubmitDate">
        <div class="grid grid-cols-2 gap-2 border-b-[1px]">
          <q-list dense class=" border-e-[1px]">
            <q-item clickable v-ripple @click="selectOption('today')">
              <q-item-section>Today</q-item-section>
            </q-item>
            <q-item clickable v-ripple @click="selectOption('last7days')">
              <q-item-section>Last 7 Days</q-item-section>
            </q-item>
            <q-item clickable v-ripple @click="selectOption('last30days')">
              <q-item-section>Last 30 Days</q-item-section>
            </q-item>
            <q-item clickable v-ripple @click="selectOption('thisYear')">
              <q-item-section>This Year ({{ getCurrentYear() }})</q-item-section>
            </q-item>
            <q-item clickable v-ripple @click="selectOption('lastYear')">
              <q-item-section>Last Year ({{ getLastYear() }})</q-item-section>
            </q-item>
            <q-item clickable v-ripple @click="openDateModal">
              <q-item-section>Custom Date</q-item-section>
            </q-item>
          </q-list>

          <div v-if="showDateArea" class="p-2">
            <q-input v-model="startDate" label="Start Date" type="date" outlined required/>
            <q-input v-model="endDate" label="End Date" type="date" outlined class="mt-2" required/>
          </div>
        </div>
        <div class="flex gap-2 justify-between p-2">
          <q-btn label="Clear" padding="xs" @click="selectDefault" />
          <div class="gap-2 flex">
            <q-btn label="Cancel" class="bg-[#907d60] text-white" padding="xs" @click="closeModifyModal" />
            <q-btn label="Apply" class="bg-[#907d60] text-white" padding="xs" v-if="showDateArea" type="submit"/>
          </div>
        </div>
      </q-form>
    </div>
    <q-separator class="mt-3 mb-3" />
    <div class="q-pa-md">
      <q-table
      :rows="filteredTableData"
      :columns="columns"
      class="my-sticky-header-table"
      :dense="$q.screen.lt.md"
      flat bordered
      :pagination="initialPagination"
      row-key="yourUniqueRowKey"
      >
      <!-- User Column Template -->
      <template v-slot:body-cell-user="props">
        <q-td :props="props" class="flex items-center gap-4" >
          <q-img :src="getUserImagePublicPath(props.row.user.image)" :alt="props.row.user.name" class="w-[34px] rounded-full min-[390px]:hidden md:flex"/>
          <div class="min-[390px]:flex md:block min-[390px]:gap-2">
            <p class="font-bold">
            {{ props.row.user.name }}
            </p>
            {{ props.row.user.position }}
          </div>
        </q-td>
      </template>

      <!-- Action Column Template -->
      <template v-slot:body-cell-action="props">
        <q-td :props="props">
          {{ props.row.action }}
        </q-td>
      </template>

      <!-- Date Column Template -->
      <template v-slot:body-cell-date="props">
        <q-td :props="props">
          {{ formatFullDate(props.row.date) }}
        </q-td>
      </template>

      <!-- Timestamp Column Template -->
      <template v-slot:body-cell-timestamp="props">
        <q-td :props="props">
          {{ props.row.timestamp }}
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
  setup () {
    const $q = useQuasar()
    return { $q };
  },
  data() {
    return {
      isAdmin: 0,
      responseInformation: '',
      responseStatus: '',
      email: '',
      userProfileImage: null,
      username: '',
      fullname: '',
      firstname: '',
      middlename: '',
      lastname: '',
      position: '',
      arrowDirection: false,
      status: '',
      showModal: false,
      toggleDrawers: true,
      drawer: false,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      showMenuIcon: false,
      statusCheckTimer: null,
      inventoryMenuVisible: false,
      productionVisible: false,
      // Additional here
      columns: [
        { name: 'user', label: 'User', align: 'left', field: 'user' },
        { name: 'action', label: 'Action', align: 'center', field: 'action', sortable: true },
        { name: 'date', label: 'Date', align: 'center', field: 'date', sortable: true },
        { name: 'timestamp', label: 'Timestamp', align: 'center', field: 'timestamp', sortable: true },
      ],
      tableData: [],
      searchInput: '',
      showModifyModal: false,
      showDateArea: false,
      startDate: '',
      endDate: '',
      arrowDirection_1: false,
      initialPagination: {
        page: 1,
        rowsPerPage: 10
        // rowsNumber: xx if getting data from a server
      },
    };

  },
  computed: {
    filteredTableData() {
      const searchQuery = this.searchInput.toLowerCase();
      return this.tableData.filter(row =>
        row.user.name.toLowerCase().includes(searchQuery) ||
        row.user.position.toLowerCase().includes(searchQuery) ||
        row.action.toLowerCase().includes(searchQuery) ||
        row.date.toLowerCase().includes(searchQuery) ||
        row.timestamp.toLowerCase().includes(searchQuery)
      );
    },
  },
  mounted() {
    this.loadUserData();
    this.fetchData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
      }, 5 * 1000); // 5 minutes (in milliseconds)
    },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },

  methods: {
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
            isAdmin: information.isAdmin,
          };
          SessionStorage.set('information', JSON.stringify(this.information));
        const Position = response.data.information.position;
        if (Position.toLowerCase() === 'owner') {
          this.$router.push('/dashboard/auditlogs-section');
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
    filterTableDataByDate(days) {
      this.showDateArea = false;
      this.tableData = [];
      if (days === 1 || days === 2 || days === 3 || days === 4 || days === 5) {
        axios.get(`http://localhost/Capstone-Project/backend/api/Audit_logs/auditlogs.php?type=${days}`)
          .then(response => {
            if (response.data && response.data.informations && response.data.informations.rows) {
              this.tableData = response.data.informations.rows.map(row => {
                // Extract time from timestamp and convert to 12-hour format
                const time = new Date(row.timestamp).toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });

                return {
                  user: {
                    name: row.fullname,
                    position: row.position,
                    image: row.image,
                  },
                  action: row.action,
                  date: row.date,
                  timestamp: time, // Add the formatted time property
                };
              });
            } else {
              console.error('Invalid API response structure:', response.data);
            }
          })
          .catch(error => {
            console.error('Error fetching data:', error);
          });
      } else if (days === 6) {
        this.showDateArea = true;
      }
    },
    fetchData() {
    axios.get('http://localhost/Capstone-Project/backend/api/Audit_logs/auditlogs.php?type=7')
      .then(response => {
        if (response.data && response.data.informations && response.data.informations.rows) {
          this.tableData = response.data.informations.rows.map(row => {
            // Extract time from timestamp and convert to 12-hour format
            const time = new Date(row.timestamp).toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });

            return {
              user: {
                name: row.fullname,
                position: row.position,
                image: row.image,
              },
              action: row.action,
              date: row.date,
              timestamp: time, // Add the formatted time property
            };
          });
        } else {
          console.error('Invalid API response structure:', response.data);
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
    },
    getUserImagePublicPath(image) {
      if (image) {
        // Use the correct path relative to the 'public' directory
        return `/pfp/${image}`;
      } else {
        // Return a default path or handle it as per your requirement
        return '/default_profile.png';
      }
    },
    openDateModal() {
      if(this.showDateArea === true){
        this.showDateArea = false;
      }
      else if(this.showDateArea === false){
        this.showDateArea = true;
      }
    },
    openModifyModal() {
      this.arrowDirection_1 = !this.arrowDirection_1;
      if(this.showModifyModal === true){
        this.showModifyModal = false;

      }
      else if(this.showModifyModal === false){
        this.showModifyModal = true;
      }
    },
    closeModifyModal() {
      this.showModifyModal = false;
    },
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
    },
    toggleProduction(){
      this.productionVisible = !this.productionVisible;
    },
    selectDefault(){
      this.fetchData();
    },
    selectOption(option) {
      switch (option) {
        case 'today':
          this.filterTableDataByDate(1);
          this.arrowDirection_1 = !this.arrowDirection_1;
          break;
        case 'last7days':
          this.filterTableDataByDate(2);

          this.arrowDirection_1 = !this.arrowDirection_1;
          break;
        case 'last30days':
          this.filterTableDataByDate(3);


          this.arrowDirection_1 = !this.arrowDirection_1;
          break;
        case 'thisYear':
          this.filterTableDataByDate(4);


          break;
        case 'lastYear':
          this.filterTableDataByDate(5);


          this.arrowDirection_1 = !this.arrowDirection_1;
          break;
        case 'customDate':
          this.filterTableDataByDate(6);


          this.arrowDirection_1 = !this.arrowDirection_1;
          break;
        default:
          break;
      }

      this.closeModifyModal();
    },
    formatFullDate(dateString) {
      if (dateString) {
        const options = { month: 'long', day: 'numeric', year: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
      } else {
        return 'N/A';
      }
    },
    getCurrentYear() {
      return new Date().getFullYear();
    },
    getLastYear() {
      return new Date().getFullYear() - 1;
    },
    onSubmitDate() {
      this.tableData = [];
      axios.get(`http://localhost/Capstone-Project/backend/api/Audit_logs/auditlogs.php?type=6&startDate=${this.startDate}&endDate=${this.endDate}`)
      .then(response => {
      if (response.data && response.data.informations && response.data.informations.rows) {
        this.tableData = response.data.informations.rows.map(row => ({
          user: {
            name: row.fullname,
            position: row.position,
            image: row.image,
          },
          action: row.action,
          date: row.date,
          timestamp: row.timestamp,
        }));
      } else {
        console.error('Invalid API response structure:', response.data);
      }
    })
    .catch(error => {
      console.error('Error fetching data:', error);
    });
    },
    // Old Data
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
          this.$router.push('/dashboard/auditlogs-section');
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
              message: 'Your account is currently inactive. Please contact the administrator.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }
          // If another value add here
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
    formatDate(dateString) {
      const options = { month: 'long', day: 'numeric', year: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
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
    toggleModal() {
      this.arrowDirection = !this.arrowDirection;
      this.showModal = !this.showModal;
    },
    updateSearch(newValue) {
      this.searchInput = newValue;
    },


    closeModal() {
      this.showSuccessModal = false;
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
    background-color: #667085
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
