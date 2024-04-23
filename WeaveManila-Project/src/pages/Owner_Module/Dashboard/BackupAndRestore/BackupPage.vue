<template>
<SideBar/>
<q-page class="bg-[#f5f5f5] ">
  <div class="text-[30px] bg-white p-4 flex justify-between">
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
    <div class='flex items-center'>
      <q-img
        :src="getUserProfileImagePath()"
        alt="Description of the image"
        class="w-12 md:w-12 rounded-full"
      />
      <q-icon :name="modalVisible ? 'keyboard_arrow_up' : 'keyboard_arrow_down'" size='md' @click="toggleModals" />
      <div v-show="modalVisible" class="fixed right-3 -top-[150px] overflow-y-auto z-50" @click="toggleModals">
        <div class="flex items-center justify-center min-h-screen">
          <div class="bg-white rounded-lg shadow-xl text-[16px]">
            <div class='bg-[#291B0E] w-full h-[50px] rounded-lg'>
            </div>
            <div class='p-4 px-2 relative '>
              <q-img
                :src="getUserProfileImagePath()"
                alt="Description of the image"
                class="w-12 md:w-14 rounded-full absolute -top-[30px] left-[64px] "
              />
              <div class='mt-4'>
                <div class='text-center mb-2'>
                  {{ getLimitedFullname(fullname, 25) }}
                </div>
                <router-link to="/dashboard/account-settings" class='p-2'>
                  <q-icon name="settings" class="mr-2"/> <span >Account Settings</span>
                </router-link>
                <div @click="OpenLogout = true" class='flex items-center p-2 hover:bg-red-200 hover:text-red-500'>
                  <q-icon name="logout" class="text-[16px] font-bold mr-3"/>
                  <p>Logout</p>
                </div>
              </div>
            </div>

          </div>
        </div>
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
              <p class="">{{ daysLeft }} day(s) left</p>
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
              <div class="w-1/2 grid grid-cols-1">
                <q-btn label="Save to Local Storage" @click="backupData" rounded class="bg-[#281A0D] text-white w-[260px]" icon="save" />
                <q-btn label="Send to your Email" @click="SendToEmail" rounded class="bg-[#281A0D] text-white w-[260px] mt-3" icon="send"/>
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
</q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import moment from 'moment';
import SideBar from '../Essentials/SideBar.vue';

export default {
  components: {
    SideBar,
  },
  data() {
    return {
      modalVisible: false,
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
      daysLeft: 0,
      logs: [],
    };
  },
  mounted() {
    this.getBackupDump();
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
    toggleModals() {
      this.modalVisible = !this.modalVisible;
    },
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

          const currentDate = new Date();

          this.logs = response.data.backupData.map(log => {
            const timestamp = new Date(log.timestamp);
            if (!isNaN(timestamp.getTime())) {
              const date = `${timestamp.getMonth() + 1}/${timestamp.getDate()}/${timestamp.getFullYear()}`;
              const hours = timestamp.getHours();
              const minutes = timestamp.getMinutes();
              const period = hours >= 12 ? 'PM' : 'AM';
              const formattedHours = hours % 12 || 12;
              const formattedMinutes = minutes.toString().padStart(2, '0');


              const isToday = timestamp.getDate() === currentDate.getDate() &&
                            timestamp.getMonth() === currentDate.getMonth() &&
                            timestamp.getFullYear() === currentDate.getFullYear();


              const timeDiff = Math.abs(currentDate - timestamp);
              const diffDays = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

              // Construct the string with days ago information
              const daysAgo = diffDays === 1 ? '1 day ago' : `${diffDays} days ago`;


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
    getBackupDump(){
      axios.get('http://localhost/Capstone-Project/backend/api/BackupAndRestore/backup_second.php?type=dump_sql')
      .then(response => {
        console.log(response.data);
      })
      .catch(error => {
        console.error('Error fetching logs:', error);
      });
    },
    backupData() {
      axios.get(`http://localhost/Capstone-Project/backend/api/BackupAndRestore/backup_second.php?type=backup_dump&email=${this.email}`)
        .then(response => {
          const content = response.data.content.substring(response.data.content.indexOf('content":"') + 108);
          const url = window.URL.createObjectURL(new Blob([content]));

          // Construct filename in Month-Day-Year format
          const currentDate = new Date();
          const month = String(currentDate.getMonth() + 1).padStart(2, '0');
          const day = String(currentDate.getDate()).padStart(2, '0');
          const year = currentDate.getFullYear();
          const filename = `backup_${month}-${day}-${year}.sql`;

          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', filename); // Set the filename
          document.body.appendChild(link);
          link.click();
          this.fetchLogs();
        })
        .catch(error => {
          console.error('Error fetching backup:', error);
        });
    },

    SendToEmail() {
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

            this.$router.push('/dashboard/backup-section');
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

