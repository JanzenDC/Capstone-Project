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

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2">
          <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
        </div>
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
        <span class="font-bold">Data Backup and Restore</span>
        <div class="text-[16px]">Efficiently safeguard and recover your data for seamless continuity and security.</div>
      </div>
    </div>


  </div>
  <div class="p-4">
      <div class="flex mt-3">
        <router-link to="/dashboard/backup-section">
            <div class="flex w-[155px] bg-white h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
              <q-icon name="backup"/>
              <p>Backup Data</p>
            </div>
          </router-link>
          <router-link to="/dashboard/restore-section">
            <div class="flex  w-[155px] text-[#b8b8b8] border-l-2 border-t-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
              <q-icon name="restore"/>
              <p>Restore Data</p>
            </div>
          </router-link>
      </div>
      <div class="bg-white px-4 py-3">
        <div>
          <div class="w-full flex gap-4">
            <div class="text-h1 p-4 text-[#281A0D]">
              <q-icon name="backup"/>
            </div>
            <div class="text-h3 p-4">
              <p class="text-h4">Next Automatic Backup:</p>
              <p class="">{{ daysLeft }} days left</p>
            </div>
          </div>
          <div class="w-full border border-[#281A0D] h-auto relative p-4 mt-10">
            <div class="absolute -top-4 left-4 bg-white text-h6 py-1 px-2 rounded">
              <p class="text-[#281A0D] font-semibold">Manual Backup</p>
            </div>

            <p class="text-sm mt-2 leading-tight">
              <span class="font-semibold">Note:</span> Your data is important! To ensure its safety, we recommend performing a manual backup. Instructions will be sent to your email address shortly.
            </p>

            <div class="flex mt-10">
              <div class="w-1/2">
                <q-btn label="Backup" @click="backupData" rounded class="bg-[#281A0D] text-white" icon="backup"/>
              </div>
              <div class="w-1/2">
                <div v-if="logs.length > 0">
                  <h3>Backup Logs:</h3>
                  <ul>
                    <li v-for="(log, index) in displayedLogs" :key="index">{{ log }}</li>
                  </ul>
                </div>
                <div v-else>
                  No backup logs available.
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
</q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import moment from 'moment';

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

      // New Data
      daysLeft: 0,
      logs: [],
    };
  },
  mounted() {
    this.loadUserData();
    this.calculateDaysLeft();
    this.fetchLogs();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  computed: {
    displayedLogs() {
      return this.logs.slice(0, 3);
    },
  },
  methods: {
    calculateDaysLeft() {
      const currentDate = moment();
      const currentDay = currentDate.date();
      const daysInMonth = moment().daysInMonth();
      const isLeapYear = moment().isLeapYear();
      let daysLeft;

      if (currentDay < 28 || (currentDay === 28 && !isLeapYear)) {
        daysLeft = 28 - currentDay;
      } else {
        daysLeft = daysInMonth - currentDay + 28 - (isLeapYear ? 1 : 0);
      }

      this.daysLeft = daysLeft;
    },
    fetchLogs() {
      axios.get('http://localhost/Capstone-Project/backend/api/BackupAndRestore/backup.php?type=backup')
        .then(response => {
          // Current timestamp
          const currentDate = new Date();

          // Convert timestamp to 12-hour format
          this.logs = response.data.backupData.map(log => {
            const timestamp = new Date(log.timestamp); // Assuming timestamp is in ISO format
            // Check if the timestamp is valid
            if (!isNaN(timestamp.getTime())) {
              const date = `${timestamp.getMonth() + 1}/${timestamp.getDate()}/${timestamp.getFullYear()}`; // Extract date component
              const hours = timestamp.getHours();
              const minutes = timestamp.getMinutes();
              const period = hours >= 12 ? 'PM' : 'AM';
              const formattedHours = hours % 12 || 12; // Convert 0 to 12
              const formattedMinutes = minutes.toString().padStart(2, '0'); // Add leading zero if needed

              // Check if the log was made today
              const isToday = timestamp.getDate() === currentDate.getDate() &&
                            timestamp.getMonth() === currentDate.getMonth() &&
                            timestamp.getFullYear() === currentDate.getFullYear();

              // Calculate the difference in days between current date and log timestamp
              const timeDiff = Math.abs(currentDate - timestamp);
              const diffDays = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

              // Construct the string with days ago information
              const daysAgo = diffDays === 1 ? '1 day ago' : `${diffDays} days ago`;

              // Construct the final string based on conditions
              if (isToday) {
                return `${date} ${formattedHours}:${formattedMinutes} ${period} (Today)`;
              } else {
                return `${date} ${formattedHours}:${formattedMinutes} ${period} (${daysAgo})`;
              }
            } else {
              return 'Invalid timestamp';
            }
          });
        })
        .catch(error => {
          console.error('Error fetching logs:', error);
        });
    },



    backupData() {
      const formData = {
        email: this.email,
      };
      axios.post('http://localhost/Capstone-Project/backend/api/BackupAndRestore/backup.php/',formData)
        .then(response => {
          console.log(response.data);
          const Status = response.data.status;
          const Message = response.data.message;
          if (Status === "success") {
            this.$q.notify({
              color: 'green',
              message: `${Message}.`,
            });
            this.fetchLogs();
          }
          if (Status === "fail") {
            this.$q.notify({
              color: 'negative',
              message: `${Message} Please try again.`,
            });
          }
        })
        .catch(error => {
          console.error('Error fetching logs:', error);
        });
    },









    // Old Data
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
        // Update the local status and take appropriate action if it has changed
        if (this.status !== latestStatus) {
          this.status = latestStatus;

          if (this.status === 0) {
            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
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

            this.$router.push('/dashboard/backup-section');
          } else {

            this.$q.notify({
              type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }

          if (this.status == 0) {

            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
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

