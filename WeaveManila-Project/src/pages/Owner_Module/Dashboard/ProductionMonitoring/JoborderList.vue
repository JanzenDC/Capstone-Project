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
            <span class="font-bold">Job Order List</span>
            <div class="text-[16px] text-[#999999]">Lorem Ipsum</div>
          </div>
        </div>
      <LogoutTop />
    </div>
    <div class="p-4">
    <div class="bg-white px-4 py-3 rounded h-[400px]">
      <div class='flex justify-between'>
        <div>
          <q-input label="Search..." dense outlined>
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
          :pagination="initialPagination"
        >
          <!-- <template v-slot:body-cell-selection="props">
            <q-td :props="props">
              <q-checkbox
                v-model="props.selected"
                :val="props.row.pjoID"
                @input="handleCheckboxChange(props.row.pjoID)"
              />
            </q-td>
          </template> -->
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
              <q-btn icon='assignment' class='bg-[#101828] text-white ms-1 me-1' @click='ViewForm(props.row.jobOrder)'>
                <q-tooltip :offset="[0, 8]">View</q-tooltip>
              </q-btn>
              <q-btn icon='edit' class='bg-blue-600 text-white ms-1 me-1' @click='EditForm(props.row.id)'>
                <q-tooltip :offset="[0, 8]">Edit</q-tooltip>
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

<q-dialog
    v-model="previewForm"
    full-width
    full-height
>
<q-card>
    <q-card-section class="row items-center q-pb-none">
      <div class="text-h6 flex items-center">
        <q-icon name="assignment_add" class="w-[48px] h-[48px]"/>
        JO {{ joNumber }}

      </div>
      <q-space />
      <q-btn icon="close" flat round dense v-close-popup />
    </q-card-section>
    <q-card-section>
      <div class="flex items-end justify-end gap-2">
        <q-btn icon="download" @click="generatePDF"/>
        <q-btn icon="print" @click="printContent"/>
      </div>
    </q-card-section>
    <q-card-section class="overflow-y-auto overflow-x-hidden h-[460px] flex justify-center items-center">
      <div class="border-[#634832] border ">
        <div  id="content">
          <div class="p-2 text-center w-[1000px]">
            <div class="font-bold text-h6">
              WEAVEMANILA INC.
            </div>
            <div>
              KM 543 DIVERSION ROAD STO.DOMINGO ALBAY
            </div>
            <div class="font-bold text-h5">
              JOB ORDER FORM - CARPET DIVISION
            </div>
          </div>

          <div class='flex'>
            <div class='w-1/2 p-2'>
              <div class='flex border border-[#967259] p-5 text-[20px] rounded gap-4'>
                <span class='font-bold'>Endorse</span>
                {{ endorseName }}
              </div>
            </div>
            <div class='w-1/2 px-10'>
              <div>J.O number: {{ joNumber }}</div>
              <div>Date: {{ dateFetch }}</div>
              <div>Reference: {{ reference }}</div>
              <div>Delivery Date: {{ deliveryDate }}</div>
            </div>
          </div>

          <div class='text-[16px] p-2'>
            PRODUCT SPECIFICATION
          </div>
          <div class='flex'>
            <div class='w-1/2 p-2 flex'>
              <div class='w-1/2 p-2'>
                <div>Description: {{ jo_desc }}</div>
                <div>Design Pattern: {{ jo_designpattern }}</div>
                <div>Construction: {{ jo_construction }}</div>
                <div>Size: {{ jo_size }}</div>
                <div>Qty: {{ jo_qty }}</div>
                <div>Date Started: {{ jo_datestarted }}</div>
                <div>Date Finished: {{ jo_datefinished }}</div>
              </div>
              <div class='w-1/2 p-2'>
                <div>Loom: {{ jo_loom }}</div>
                <div>Color: {{ jo_color }}</div>
                <div>Leadtime: {{ jo_leadtime }}</div>
                <div>Qouta: {{ jo_qouta }}</div>
              </div>
            </div>
            <div class='w-1/2 p-2'>
              <div class='grid grid-cols-4'>
                <div class='border border-black p-2 font-bold bg-[#D0D5DD]'>
                  Weaving
                </div>
                <div class='border border-black p-2 text-center'>
                  <q-icon name='done' v-if='jo_weaving' />
                </div> <!--for Weaving-->
                <div class='border border-black p-2 font-bold bg-[#D0D5DD]'>
                  Latexing
                </div>
                <div class='border border-black p-2 text-center'>
                  <q-icon name='done' v-if='jo_latexing' />
                </div> <!--for Latexing-->
                <div class='border border-black p-2 font-bold bg-[#D0D5DD]'>
                  Tassle
                </div>
                <div class='border border-black p-2 text-center'>
                  <q-icon name='done' v-if='jo_tassle' />
                </div> <!--for Tassle-->
                <div class='border border-black p-2 font-bold bg-[#D0D5DD]'>
                  Relatexing
                </div>
                <div class='border border-black p-2 text-center'>
                  <q-icon name='done' v-if='jo_re_latexing' />
                </div> <!--for Relatexing-->
                <div class='border border-black p-2 font-bold bg-[#D0D5DD]'>
                  Trimming
                </div>
                <div class='border border-black p-2 text-center'>
                  <q-icon name='done' v-if='jo_trimming' />
                </div> <!--for Trimming-->
                <div class='border border-black p-2 font-bold bg-[#D0D5DD]'>
                  Pipping
                </div>
                <div class='border border-black p-2 text-center'>
                  <q-icon name='done' v-if='jo_pipping' />
                </div> <!--for Pipping-->
                <div class='border border-black p-2 font-bold bg-[#D0D5DD]'>
                  Cleaning
                </div>
                <div class='border border-black p-2 text-center'>
                  <q-icon name='done' v-if='jo_cleaning' />
                </div> <!--for Cleaning-->
                <div class='border border-black p-2 font-bold bg-[#D0D5DD]'>
                  Cutting
                </div>
                <div class='border border-black p-2 text-center'>
                  <q-icon name='done' v-if='jo_cutting' />
                </div> <!--for Cutting-->
              </div>
            </div>
          </div>

          <div class='text-[16px] p-2'>
            MATERIAL SPECIFICATION
          </div>
          <div class="mt-3 p-2">
            <q-table
              dense bordered
              :rows="mats_rows"
              :columns="mats_columns"
              row-key="index"
              hide-bottom
              separator="cell"
            >
            </q-table>
          </div>

          <div class='text-[16px] p-2'>
            REMARKS
          </div>
          <div class='flex'>
            <div class='w-1/2 p-2'>
              <div class='w-full text-center text-bold border p-2'>Item Actual Weight</div>
              <q-table
                dense bordered
                :rows="remarks_rows"
                :columns="remarks_cols"
                row-key="index"
                hide-bottom
                separator="cell"
              >
              </q-table>
            </div>
            <div class='w-1/2 p-2'>
              <div class='w-full text-center text-bold border p-2'>Total Material Used</div>
              <q-table
                dense bordered
                :rows="remarks_second_rows"
                :columns="remarks_second_cols"
                row-key="index"
                hide-bottom
                separator="cell"
              >
              </q-table>
            </div>
          </div>

          <div class='text-[16px] p-2'>
            DESIGN SPECIFICATION (not required)
          </div>
          <div class='p-2'>
            <q-table
                dense bordered
                :rows="design_rows"
                :columns="design_columns"
                row-key="index"
                hide-bottom
                separator="cell"
              >
              </q-table>
          </div>

          <div class='text-[16px] p-2'>
            POST DATA SPECIFICATION (not required)
          </div>
          <div class='p-2'>
            <q-table
                dense bordered
                :rows="postdata_rows"
                :columns="postdata_columns"
                row-key="index"
                hide-bottom
                separator="cell"
              >
                <template v-slot:header-cell-warp="props">
                  <q-th :props="props">
                    <div class='p-4 mb-5'></div>
                    {{ props.col.label }}
                  </q-th>
                </template>
                <template v-slot:header-cell-weft="props">
                  <q-th :props="props">
                    <div class='p-4 mb-1'>
                      Waste
                    </div>
                    {{ props.col.label }}
                  </q-th>
                </template>
                <template v-slot:header-cell-insert="props">
                  <q-th :props="props">
                    <div class='p-4 mb-5'></div>
                    {{ props.col.label }}
                  </q-th>
                </template>
              </q-table>
          </div>

          <div class='text-[16px] p-2'>
            MATERIAL ISSUANCE
          </div>
          <div class='p-2'>
            <q-table
                dense bordered
                :rows="material_rows"
                :columns="material_cols"
                row-key="index"
                hide-bottom
                separator="cell"
              >
              </q-table>
          </div>
        </div>
      </div>
    </q-card-section>
</q-card>
</q-dialog>

<q-dialog
    v-model="editForm"
    full-width
    full-height
>
<q-card>
    <q-card-section class="row items-center q-pb-none">
      <div class="text-h6 flex items-center">
        <q-icon name="assignment_add" class="w-[48px] h-[48px]"/>
        JO {{ joNumber }}

      </div>
      <q-space />
      <q-btn icon="close" flat round dense v-close-popup />
    </q-card-section>
    <q-card-section>
      <div class="flex items-end justify-end gap-2">
        <q-btn icon="download" @click="generatePDF"/>
        <q-btn icon="print" @click="printContent"/>
      </div>
    </q-card-section>
    <q-card-section class="overflow-y-auto overflow-x-hidden h-[460px]">
      <JobOrderPage />
    </q-card-section>
</q-card>
</q-dialog>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import JobOrderPage from './job_order/JobOrder.vue';
import SideBar from '../Essentials/SideBar.vue';
import LogoutTop from '../Essentials/LogoutTop.vue';

export default {
  components: {
    JobOrderPage,
    SideBar,
    LogoutTop
  },
  data() {
    return {
      editForm: false,
      previewForm: false,
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
        rowsPerPage: 4
      },


      joNumber: '',
      endorseName: '',
      dateFetch: '',
      reference: '',
      deliveryDate: '',
      jo_desc: '',
      jo_designpattern: '',
      jo_construction: '',
      jo_size: '',
      jo_qty: '',
      jo_datestarted: '',
      jo_datefinished: '',
      jo_loom: '',
      jo_color: '',
      jo_leadtime: '',
      jo_qouta: '',
      jo_weaving: '',
      jo_tassle: '',
      jo_trimming: '',
      jo_cleaning: '',
      jo_latexing: '',
      jo_re_latexing: '',
      jo_pipping: '',
      jo_cutting: '',
      mats_columns: [
        { name: 'type', align: 'left', label: '', field: 'type', sortable: true },
        { name: 'material_used', align: 'left', label: 'Material Used', field: 'material_used', sortable: true },
        { name: 'consumption', align: 'left', label: 'Consumption in WT. (KG)', field: 'consumption', sortable: true },
        { name: 'waste_allow', align: 'right', label: 'Waste Allow', field: 'waste_allow', sortable: true },
        { name: 'total', align: 'right', label: 'Total Allow Issuance', field: 'total', sortable: true },
      ],
      mats_rows: [],
      remarks_cols: [
        { name: 'quantity', align: 'left', label: 'Quantity', field: 'quantity', sortable: true },
        { name: 'weight', align: 'left', label: 'Weight', field: 'weight', sortable: true },
        { name: 'unit', align: 'left', label: 'Unit', field: 'unit', sortable: true },
      ],
      remarks_rows: [],
      remarks_second_cols: [
        { name: 'material_used', align: 'left', label: 'Material Used', field: 'material_used', sortable: true },
        { name: 'quantity', align: 'left', label: 'Quantity', field: 'quantity', sortable: true },
        { name: 'unit', align: 'left', label: 'Unit', field: 'unit', sortable: true },
      ],
      remarks_second_rows: [],

      design_columns: [
        { name: 'pattern_name', align: 'left', label: 'Pattern Name', field: 'pattern_name', sortable: true },
        { name: 'DPI', align: 'left', label: 'DPI', field: 'DPI', sortable: true },
        { name: 'EPI', align: 'left', label: 'EPI', field: 'EPI', sortable: true },
        { name: 'threading', align: 'left', label: 'Threading', field: 'threading', sortable: true },
        { name: 'harness_lift', align: 'left', label: 'Harness Lift', field: 'harness_lift', sortable: true },
        { name: 'Pedal', align: 'left', label: 'Pedal', field: 'Pedal', sortable: true },
      ],
      design_rows: [],

      postdata_columns: [
      { name: 'setting', align: 'left', label: 'Setting (W)', field: 'setting', sortable: true },
      { name: 'weaving', align: 'left', label: 'Weaving (W)', field: 'weaving', sortable: true },
      { name: 'output', align: 'left', label: 'Output Width', field: 'output', sortable: true },
      { name: 'warp', align: 'left', label: 'Warp', field: 'warp', sortable: true },
      { name: 'weft', align: 'left', label: 'Weft', field: 'weft', sortable: true },
      { name: 'insert', align: 'left', label: 'Insert', field: 'insert', sortable: true },
      ],
      postdata_rows: [],

      material_cols: [
      { name: 'date', align: 'left', label: 'Date', field: 'date', sortable: true },
      { name: 'material_desc', align: 'left', label: 'Material Description', field: 'material_desc', sortable: true },
      { name: 'quantity', align: 'left', label: 'Quantity', field: 'quantity', sortable: true },
      { name: 'unit', align: 'left', label: 'Unit', field: 'unit', sortable: true },
      { name: 'returned', align: 'left', label: 'Returned', field: 'returned', sortable: true },
      { name: 'balance', align: 'left', label: 'Balance', field: 'balance', sortable: true },
      { name: 'issued_by', align: 'left', label: 'Issued by', field: 'setting', sortable: true },
      ],
      material_rows: [],
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
    EditForm(event){
      console.log(event)
      this.joNumber = event;
      this.editForm = true;
      SessionStorage.set('joNumber', JSON.stringify(this.joNumber));
    },
    ViewForm(event){
      const unitAbbreviations = {
        'Feet': 'ft',
        'Meters': 'm',
        'Centimeters': 'cm',
        'Millimeters': 'mm',
        'Inches': 'in'
      };

      axios.get(`https://weavemanila.optikl.ink/backend/api/ProductionMonitoring/job_order/job_orderform.php?get=${event}`)
      .then((response) => {
        this.previewForm = true;
        console.log(response.data)
        const PJO = response.data.PJOdata;
        this.joNumber = PJO.job_order_no.toString().padStart(3, '0');
        this.endorseName = PJO.endorse;
        this.reference = PJO.reference;
        this.deliveryDate = PJO.delivery_date;

        this.jo_desc = PJO.description;
        this.jo_designpattern = PJO.design_pattern;
        this.jo_construction = PJO.construction;
        // Assuming PJO.width, PJO.length, and PJO.size_selected are available
        this.jo_size = PJO.width + 'x' + PJO.length + unitAbbreviations[PJO.size_selected];

        this.jo_qty = PJO.quantity;
        this.jo_datestarted = PJO.date_started;
        this.jo_datefinished =  PJO.date_finished;
        this.jo_loom =  PJO.loom;
        this.jo_color =  PJO.color;
        this.jo_leadtime =  PJO.leadtime;
        this.jo_qouta =  PJO.qouta;
        this.jo_weaving = PJO.weaving;
        this.jo_tassle = PJO.tassle;
        this.jo_trimming = PJO.trimming;
        this.jo_cleaning = PJO.cleaning;
        this.jo_latexing = PJO.latexing;
        this.jo_re_latexing = PJO.re_latexing;
        this.jo_pipping = PJO.pipping;
        this.jo_cutting = PJO.cutting;

        this.mats_rows = response.data.PJOlink.mats_specs.map(row => {
          return {
              type: row.type,
              material_used: row.material_used,
              waste_allow: row.waste_allow,
              total: row.total_allow_issuance
            };
        })
        this.remarks_rows = response.data.PJOlink.item_actual_weight.map(row => {
          return {
              quantity: row.quantity,
              weight: row.weight,
              unit: row.unit
            };
        })
        this.remarks_second_rows = response.data.PJOlink.total_material_used.map(row => {
          return {
              material_used: row.material_used,
              quantity: row.quantity,
              unit: row.unit
            };
        })
        this.design_rows = response.data.PJOlink.design_specs_tbl.map(row => {
          return {
              pattern_name: row.pattern_name,
              DPI: row.dpi,
              EPI: row.epi,
              threading: row.threading,
              harness_lift: row.harness_lift,
              padel: row.padel
            };
        })
        this.postdata_rows = response.data.PJOlink.post_data_specs_tbl.map(row => {
          return {
              setting: row.setting_w,
              weaving: row.weaving_w,
              output: row.output_width,
              warp: row.warp_waste,
              weft: row.weft_waste,
              insert: row.insert_waste,
            };
        })
        this.material_rows = response.data.PJOlink.material_issuance_tbl.map(row => {
          return {
              date: row.date,
              material_desc: row.material_desc,
              quantity: row.quantity,
              unit: row.unit,
              returned: row.returned,
              balance: row.balance,
              issued_by: row.issued_by,
            };
        })
      }).catch(error => {
          console.error("Error fetching PJO data:", error);
      });
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

      axios.get('https://weavemanila.optikl.ink/backend/api/ProductionMonitoring/job_order/job_order.php?type=getPJOall')
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
    generatePDF() {
      const pdf = new jsPDF();
      const content = document.getElementById('content');

      // Use html2canvas to render HTML to canvas
      html2canvas(content).then(canvas => {
        // Convert canvas to base64 image data
        const imgData = canvas.toDataURL('image/jpeg');

        const pageWidth = 210; // A4 width in mm
        const pageHeight = 297; // A4 height in mm

        const imgWidth = pageWidth;
        const imgHeight = (canvas.height * pageWidth) / canvas.width;


        let position = 0;
        if (imgHeight > pageHeight) {

          pdf.addPage();
          position = -pageHeight;

          pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
        } else {
          pdf.addImage(imgData, 'JPEG', 0, 0, imgWidth, imgHeight);
        }

        while (position + pageHeight < imgHeight) {
          position += pageHeight;
          pdf.addPage();
          pdf.addImage(imgData, 'JPEG', 0, -position, imgWidth, imgHeight);
        }

        // Save PDF
        const pdfformat = `JobOrder-form.pdf`;
        pdf.save(pdfformat);

        // this.pdfData = pdf.output('blob');
        // console.log("PDF Data",this.pdfData);
      });
    },
    printContent() {
      this.previewForm = false;
      const printableContent = document.getElementById('content');
      const originalContents = document.body.innerHTML;
      document.body.innerHTML = printableContent.innerHTML;
      window.print();
      document.body.innerHTML = originalContents;
      window.addEventListener('afterprint', this.reloadPage);
      this.reloadPage();
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
