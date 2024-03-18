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
          <q-icon name="dashboard" class="mr-2" /> <span>Dashboard</span>
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
            <div @click="OpenLogout = true">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </div>
          </div>
      </li>
  </ul>
</q-drawer>
<q-page class="bg-[#f5f5f5] ">
  <div class="text-[30px] bg-white p-4">
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
        <span class="font-bold">Job Order List</span>
        <div class="text-[16px] text-[#999999]">Lorem Ipsum</div>
      </div>
    </div>


  </div>
  <div class="p-4">
    <div class="flex mt-3">
        <router-link to="/dashboard/productionplan-section">
          <div class="flex  w-[180px] text-[#b8b8b8] border-l-2 border-t-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">

            <q-icon name="event"/>
            <p>Production Plan</p>
          </div>
        </router-link>
        <router-link to="/dashboard/joborderlist-section">
          <div class="flex w-[180px] bg-white h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="list"/>
            <p>Job Order List</p>
          </div>
        </router-link>
        <router-link to="/dashboard/weaver-section">
          <div class="flex w-[180px] text-[#b8b8b8] border-t-2 border-l-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
              <q-icon name="group"/>
              <p>Weaver List</p>
            </div>
        </router-link>
    </div>
    <div class="bg-white px-4 py-3 rounded h-[400px]">
      <div class='flex justify-between'>
        <div>
          <q-input v-model="filtersearch" label="Search..." dense outlined>
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-input>
        </div>
        <div classs='flex '>
          <q-btn icon='download' class='ms-1 me-1'/>
          <q-btn icon='print' class='ms-1 me-1'/>
          <q-btn icon='refresh' class='ms-1 me-1'/>
          <q-btn icon='filter_list' class='ms-1 me-1'/>
        </div>
      </div>

      <div class='mt-4'>
        <q-table
          class="my-sticky-header-table"
          dense bordered
          :rows="rows"
          :columns="columns"
          row-key="pjoID"
          :selected-rows-label="getSelectedString"
          selection="multiple"
          :pagination="initialPagination"
          v-model:selected="selected"
        >
          <template v-slot:body-cell-selection="props">
            <q-td :props="props">
              <q-checkbox
                v-model="props.selected"
                :val="props.row.pjoID"
                @input="handleCheckboxChange(props.row.pjoID)"
              />
            </q-td>
          </template>
          <template v-slot:body-cell-status="props">
            <q-td :props="props">
              <span v-if="props.row.status === 'Done'" class="text-green-600 p-2 rounded-full bg-green-300">
                ● Done
              </span>
              <span v-else-if="props.row.status === 'Ongoing'" class="text-yellow-600 p-2 rounded-full bg-yellow-300">
                ● Ongoing
              </span>
              <span v-else-if="props.row.status === 'Pending'" class="text-red-600 p-2 rounded-full bg-red-300">
                ● Pending
              </span>
            </q-td>
          </template>
          <template v-slot:body-cell-action="props">
            <q-td :props="props">
              <q-btn icon='history' class='bg-[#344054] text-white ms-1 me-1'/>
              <q-btn icon='assignment' class='bg-[#101828] text-white ms-1 me-1' >
                <q-tooltip :offset="[0, 8]">View</q-tooltip>
              </q-btn>
              <q-btn icon='delete' class='bg-[#B3261E] text-white ms-1 me-1' @click="handleDeleteClick">
                <q-tooltip :offset="[0, 8]">Remove</q-tooltip>
              </q-btn>
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
<q-dialog v-model="OpenDelete">
  <q-card>
    <q-card-section class="row items-center q-pb-none">
      <div class="py-1 px-2 border text-[24px]"><q-icon name="delete"/></div>
      <q-space />
      <q-btn icon="close" flat round dense v-close-popup />
    </q-card-section>

    <q-card-section>
      <div class="text-h6 font-bold">Delete</div>
      <p>Are you sure you want to delete this? This</p>
      <p>action cannot be undone.</p>
    </q-card-section>

    <q-card-actions class="flex justify-center items-center">
      <div class="w-1/2 p-1">
        <q-btn flat label="Cancel" outline v-close-popup class="w-full border" @click="handleCancel"/>
      </div>
      <div class="w-1/2 p-1">
        <q-btn
          @click="HandleRemove"
          flat
          label="Delete"
          type="submit"
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
      // New Data
      columns: [
        {name: 'jobOrderNo', label: 'Job Order No.', field: 'jobOrderNo', sortable: true},
        {name: 'commitmentDate', label: 'Commitment Date', field: 'commitmentDate', sortable: true},
        {name: 'weaver', label: 'Weaver', field: 'weaver', sortable: true},
        {name: 'size', label: 'Size', field: 'size', sortable: true},
        {name: 'total_output', label: 'Total Output (Inches)', field: 'total_output', sortable: true},
        {name: 'balance', label: 'Balance (Inches)', field: 'balance', sortable: true},
        {name: 'status', label: 'Status', field: 'status', sortable: true},
        {name: 'checked_by', label: 'Checked By', field: 'checked_by', sortable: true},
        {name: 'edited', label: 'Edited', field: 'edited', sortable: true},
        {name: 'action', label: 'Action', field: 'action', sortable: true, align: 'center'},

      ],
      rows: [],
      selected: [],
      initialPagination: {
        page: 1,
        rowsPerPage: 10
      },
      OpenDelete: false,
    };
  },
  mounted() {
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
    this.fetchallPJO();
  },
  methods: {
      handleDeleteClick() {
        this.OpenDelete = true;
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
    extractSelectedIds() {
      return this.selected.map(item => item.supplierID);
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

      axios.get('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/job_order/job_order.php?type=getPJOall')
      .then((response) => {
          console.log(response.data);
          this.rows = response.data.PJOdata.map(row => {
            const sizeSelectedAbbreviated = unitAbbreviations[row.size_selected] || row.size_selected;
            const jobOrderDate = new Date(row.date);
            let year = jobOrderDate.getFullYear().toString();
            year = year.slice(2); // Remove first two digits

            const jobOrderNoPadded = year + '-' + row.job_order_no.toString().padStart(3, '0');

              // Convert length to inches based on unit selected
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
              // extract the year in row.date and apply in jobOrderNoPadded the format will be row.date-jobOrderNoPadded
              // Calculate value
              const value = lengthInInches / row.qouta;
              const value2 = value - row.total_output_sum;
              // Determine status
              let status;
              if (value === row.total_output_sum) {
                  status = 'Done';
              } else if (value > 0) {
                  status = 'Ongoing';
              } else {
                  status = 'Pending';
              }

              return {
                  id: row.pjoID,
                  jobOrderNo: jobOrderNoPadded,
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
      axios.get(`http://localhost/Capstone-Project/backend/api/verification.php?email=${this.email}`)
      .then(response => {
        console.log(response.data);

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

            this.$router.push('/dashboard/joborderlist-section');
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
