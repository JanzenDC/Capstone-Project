<template>

  <q-header elevated class="bg-white w-full text-black h-[100px]  md:flex md:justify-between border-2">
    <div class="md:w-[400px] p-4 md:flex min-[390px]:hidden">
        <div>
          <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
          <q-img
            src="../../../assets/favicon-128x128.png"
            alt="Description of the image"
            class="w-[60px] md:w-[60px] "
          />
        </div>
        <div class="w-[250px]">
          <p class="text-[20px] text-[#8F8073] font-bold ">WEAVEMANILA INC.</p>
          <p class="text-[12px] text-[#9e896a]">Production Monitoring & Inventory Management System</p>
        </div>
    </div>
    <div class="flex items-center p-4 gap-2 min-[390px]:justify-between">
      <q-btn flat @click="drawer = !drawer" round dense icon="menu" class="md:hidden"/>
      <div class="flex items-center p-4 gap-2">
      <q-icon name="notifications" class="text-[21px]"/>
      <div>
          <q-img
            :src="getUserProfileImagePath()"
            alt="Description of the image"
            class="w-12 md:w-12 rounded-full border-black border"
          />
          </div>
          <div>
            {{ firstname }}
          </div>
          <q-icon
            :name="arrowDirection ? 'arrow_drop_up' : 'arrow_drop_down'"
            class="text-[25px] cursor-pointer"
            @click="toggleModal"
          />
        </div>
        <div v-if="showModal" class="fixed right-5 top-[110px] transform bg-white p-3 border border-gray-300 z-50 rounded-md drop-shadow-lg w-[308px] h-[200px]">
        <div class="flex justify-center">
          <div>
            <div class="flex justify-center mt-3 ">
              <q-img
                :src="getUserProfileImagePath()"
                alt="Description of the image"
                class="w-[80px] rounded-full border-black border"
              />
            </div>
            <div class="font-bold">{{ firstname }} {{ lastname }}</div>
            <div class="text-center">{{ position }}</div>
          </div>
        </div>
        <router-link to="/dashboard/account-settings">
          <p class="flex justify-between text-[16px]">
            Account Settings <q-icon name="manage_accounts" class="mr-2 text-[16px]"/>
          </p>
        </router-link>
        <router-link @click="logout" to="/">
          <p class="flex justify-between text-[16px]">
            Logout <q-icon name="logout" class="mr-2 text-[16px]"/>
          </p>
        </router-link>
      </div>
    </div>
  </q-header>
  <q-drawer
    show-if-above
    v-model="drawer"
    side="left"
    bordered
    :width="250">
        <ul class="p-4">
          <li class="font-bold">Overview</li>
            <li class="py-[17px] px-[20px]">
              <div class="flex items-center">
                <router-link to="/dashboard/main-dashboard">
                <q-icon name="dashboard" class="mr-2"/> Dashboard
                </router-link>
              </div>
            </li>
            <!-- Process Section -->
            <li class="font-bold">Process</li>
            <li class="py-[17px] px-[20px]">
              <div class="flex items-center gap-2">
                <q-icon name="inventory"/> Inventory
              </div>
            </li>
            <li class="py-[17px] px-[20px] ">
              <div class="flex items-center gap-2">
                <i class="bi bi-box-seam"></i> Product Monitoring
              </div>
            </li>
            <li class="py-[17px] px-[20px]">
              <div class="flex items-center">
                <q-icon name="description" class="mr-2"/> Production Cost Report
              </div>
            </li>
            <!-- Settings Section -->
            <li class="font-bold">Settings</li>
            <li class="py-[17px] px-[20px]">
              <div class="flex items-center">
                <router-link to="/dashboard/auditlogs-section">
                  <i class="bi bi-activity"></i> Audit Logs
                </router-link>
              </div>
            </li>
            <li class="py-[17px] px-[20px]">
              <div class="flex items-center">
                <q-icon name="group" class="mr-2"/> User Management
              </div>
            </li>
        </ul>
  </q-drawer>
    <q-page class="bg-[#f5f5f5] p-4">
     <div class="bg-white md:h-[520px] rounded p-10 overflow-y-auto">
        <div class="flex justify-between items-center">
          <router-link to="/dashboard/account-settings">
            <p class="text-[15px]"><q-icon name="arrow_back_ios"/> <span class=" font-bold text-[#9e896a]">AUDIT LOGS</span></p>
          </router-link>
          <div class="flex gap-2 items-center">
              <q-input
              v-model="searchInput"
              filled
              outlined
              dense
              placeholder="Search..."
              />
            <q-btn @click="openModifyModal" label="Modify" class="h-5 bg-[#907d60] text-white">
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
  import { onBeforeUnmount } from 'vue'
  import { SessionStorage } from 'quasar';
  import axios from 'axios';

  export default {
    setup () {
      const $q = useQuasar()
      return { $q };
    },
    data() {
      return {
        responseInformation: '',
        responseStatus: '',
        email: '',
        userProfileImage: null,
        username: '',
        firstname: '',
        middlename: '',
        lastname: '',
        position: '',
        arrowDirection: false,

        showModal: false,
        drawer: false,

        // Additional here
        columns: [
          { name: 'user', label: 'User', align: 'left', field: 'user' },
          { name: 'action', label: 'Action', align: 'left', field: 'action', sortable: true },
          { name: 'date', label: 'Date', align: 'left', field: 'date', sortable: true },
          { name: 'timestamp', label: 'Timestamp', align: 'left', field: 'timestamp', sortable: true },
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
    },
    methods: {
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
                console.log(this.tableData);
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
      selectDefault(){
        this.fetchData();
      },
      selectOption(option) {
        switch (option) {
          case 'today':
            this.filterTableDataByDate(1);

            this.timeOut();
            this.arrowDirection_1 = !this.arrowDirection_1;
            break;
          case 'last7days':
            this.filterTableDataByDate(2);

            this.timeOut();
            this.arrowDirection_1 = !this.arrowDirection_1;
            break;
          case 'last30days':
            this.filterTableDataByDate(3);

            this.timeOut();
            this.arrowDirection_1 = !this.arrowDirection_1;
            break;
          case 'thisYear':
            this.filterTableDataByDate(4);

            this.timeOut();
            break;
          case 'lastYear':
            this.filterTableDataByDate(5);

            this.timeOut();
            this.arrowDirection_1 = !this.arrowDirection_1;
            break;
          case 'customDate':
            this.filterTableDataByDate(6);

            this.timeOut();
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

