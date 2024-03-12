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
        <div class="flex justify-end items-end gap-4">
          <q-btn icon="download" />
          <q-btn icon="print" />
          <q-btn icon="refresh" />

        </div>
        <q-separator class="mt-9 "/>
        <div class="overflox-y-auto overflow-x-hidden h-[300px] mt-3 flex gap-8">
          <!-- Use loop here using quasar -->
          <div v-for="item in items" :key="item.id" class="gap-2">
              <div class="w-[123px]">
                <q-img
                  src="../../../../../assets/folder_name.png"
                  alt="Description of the image"
                  class="w-[60px] md:w-[120px] cursor-pointer"
                  @click="handleImageClick(item.baseID)"
                />
                <p class="text-center">
                  {{ item.item_name }}
                </p>
              </div>
          </div>
        </div>


      </div>
    </div>

    <!-- MODAL -->
    <q-dialog v-model="ShowFolder" persistent transition-show="scale" transition-hide="scale">
      <q-card style="width: 900px; max-width: 80vw;">
        <q-card-section class="row items-center q-pb-none">
          <div class="flex items-center">

            <q-icon name='stacks'/>
            <div class="text-h6">{{ selectedIDName }}</div>
          </div>

          <q-space />
          <q-btn icon="close" flat round dense @click='CloseFolder' />
        </q-card-section>
        <q-separator />
        <q-card-section>
          <div class="flex items-end justify-end mb-3 gap-4">
            <q-btn icon="download" />
            <q-btn icon="print" />
            <q-btn icon="refresh" />
            <q-btn icon="add" label="Add table" class="bg-[#634832] text-white"/>
          </div>
          <q-separator />
          <div class="mt-3">
            <p>Product Name: <span class="text-gray-900"> {{ selectedIDName }} Taknis</span></p>
            <p>Quantity Stocks: <span class="text-gray-900"> {{ selected_Quantity }} </span> </p>
            <p class="hidden">Quantity Balance: <span class="text-gray-900 "> {{ totalBalance }} </span></p>
            <p>Quantity Balance: <span class="text-gray-900"> {{ totalBalanceRaw }} </span></p>

          </div>
          <div>

            <q-table
              flat bordered
              :rows="rows"
              :columns="columns"
              row-key="baseID"
            >

            <template v-slot:body="props">
              <q-tr :props="props">


                <q-td key="date" :props="props">
                  {{ props.row.date }}
                  <q-popup-edit v-model="props.row.date" title="Update Description" buttons v-slot="scope">
                    <q-input type="date" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="segregator" :props="props">
                  {{ props.row.segregator }}
                  <q-popup-edit v-model="props.row.segregator" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="qty_raw" :props="props">
                  {{ props.row.qty_raw }}
                  <q-popup-edit v-model="props.row.qty_raw" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="balance_raw" :props="props">
                  {{ props.row.balance_raw }}
                </q-td>

                <q-td key="qty_received" :props="props">
                  {{ props.row.qty_received }}
                  <q-popup-edit v-model="props.row.qty_received" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus/>
                  </q-popup-edit>
                </q-td>

                <q-td key="waste_gumon" :props="props">
                  {{ props.row.waste_gumon }}
                  <q-popup-edit v-model="props.row.waste_gumon" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="balance" :props="props">
                  {{ stored_Variable }}
                </q-td>


                <q-td key="action" :props="props" >
                  <div class="w-[70px] flex gap-3">
                    <q-icon
                    name="edit"
                    class="w-[18px] h-[21px] p-1 text-white bg-yellow rounded"
                  />
                  <q-icon
                    name="delete"
                    class="w-[18px] h-[21px] p-1 text-white bg-red rounded"
                    @click="deleteRow(props.row)"
                  />
                  </div>

                </q-td>

              </q-tr>
            </template>
            </q-table>

          </div>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>

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

        // Another Data
        mpoSelect: '',
        columns: [
          { name: 'date', align: 'left', label: 'Date', field: 'date', sortable: true, },
          { name: 'segregator', align: 'left', label: 'Segregator', field: 'segregator', sortable: true,},
          { name: 'qty_raw', align: 'left', label: 'Qty Raw', field: 'qty_raw', sortable: true,},
          { name: 'balance_raw', align: 'left', label: 'Balance Raw', field: 'balance_raw', sortable: true,},
          { name: 'qty_received', align: 'left', label: 'Qty Received', field: 'qty_received', sortable: true,},
          { name: 'waste_gumon', align: 'left', label: 'Waste / Gumon', field: 'waste_gumon', sortable: true,},
          { name: 'balance', align: 'left', label: 'Balance', field: 'balance', sortable: true,},
          { name: 'action', align: 'center', label: 'Actions', field: 'action'},
        ],
        rows: [],
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
    watch: {
      rows: {
        handler(newRows, oldRows) {
          let previousBalance = parseFloat(this.totalBalance);
          let totalQtyRaw = 0;
          newRows.forEach(row => {
            if (parseFloat(row.qty_raw) > parseFloat(previousBalance)) {
  
              row.qty_raw = parseFloat(previousBalance);
            }
            row.balance_raw = previousBalance - parseFloat(row.qty_raw);
            previousBalance = parseFloat(row.balance_raw);
            totalQtyRaw += parseFloat(row.qty_raw);

            row.balance = this.calculateBalance(row);
          });
          this.totalBalanceRaw = previousBalance;
          // this.totalBalanceRaw = this.totalBalance;
        },
        deep: true
      }
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

            axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_details.php?targetdata=${this.mpoIDnumber}`)
            .then(response => {
              console.log(response.data.information);
              const info =  response.data.information;
              this.items = response.data.information;
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
      CloseFolder(){
        this.ShowFolder = false;
        this.rows = [];
      },
      handleImageClick(event){
        this.ShowFolder = true;
        console.log(event)
        axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/segregation_queries/segregation.php?type=1&id=${event}`)
        .then(response => {
          const Info = response.data.result;
          this.selectedIDName = Info.item_name;
          this.selected_Quantity = Info.quantity_received;

          // Balance
          this.totalBalance = Info.quantity_received;
          this.totalBalanceRaw = Info.quantity_received;
          // this.rows.push({
          //   date: '',
          //   segregator: '',
          //   qty_raw: 0,
          //   balance_raw: parseFloat(this.totalBalance), // Ensure totalBalance is parsed as float
          //   qty_received: 0,
          //   waste_gumon: 0,
          //   balance: 0
          // });
          console.log(Info);
        }).catch(error => {
            console.error('Error fetching data:', error);
        });
      },
      addRow() {
        if (parseFloat(this.totalBalanceRaw) == 0) {
          this.$q.notify({
            type: 'negative',
            message: 'Cannot add another table.',
          });
          return;
        }

        this.rows.push({
          date: '',
          segregator: '',
          qty_raw: 0,
          balance_raw: parseFloat(this.totalBalance), // Ensure totalBalance is parsed as float
          qty_received: 0,
          waste_gumon: 0,
          balance: parseFloat(this.updatedBalance)
        });
        console.log(this.totalBalance);
        console.log(this.rows);
      },
      deleteRow(row) {
        // Implement logic to delete the specified row
        const index = this.rows.indexOf(row);
        if (index !== -1) {
          this.rows.splice(index, 1);
        }
      },
      AddData() {
        // Convert inputs to numbers using parseFloat
        const newRowQtyRaw = parseFloat(this.newRow.qty_raw) || 0;
        const newRowQtyReceived = parseFloat(this.newRow.qty_received) || 0;
        const newRowWasteGumon = parseFloat(this.newRow.waste_gumon) || 0;

        // if(newRowQtyRaw < newRowQtyReceived)
        // {
        //   this.$q.notify({
        //     type: 'negative',
        //     message: 'Wrong Input: Quantity Received is greater than Quantity Raw. Please try again.',
        //   });
        //   return;
        // }
        // Calculate balance_raw
        const balanceRaw = this.totalBalanceRaw - newRowQtyRaw;

        // Calculate balance
        const totalReceivedAndWaste = newRowQtyReceived + newRowWasteGumon;
        const balance = newRowQtyRaw - totalReceivedAndWaste;
        this.stored_Variable = balance;
        // Push new row to rows array
        this.rows.push({
          date: this.newRow.date,
          segregator: this.newRow.segregator,
          qty_raw: newRowQtyRaw,
          balance_raw: balanceRaw,
          qty_received: newRowQtyReceived,
          waste_gumon: newRowWasteGumon,
          //balance: balance,
        });

        // Update total balance
        this.totalBalanceRaw = balanceRaw;
      },





      onMainDashboard(){
        this.$router.push('/dashboard/main-dashboard');
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
              this.$router.push('/dashboard/segregate-section');
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

