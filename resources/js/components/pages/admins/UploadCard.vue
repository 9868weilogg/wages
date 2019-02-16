<template>  
  <div>
    <v-snackbar
      v-model="snackbar"
      :right="true"
      :top="true"
      :timeout="timeout"
      :color="color"
    >
      {{ text }}
      <v-progress-circular
        v-if="uploading"
        indeterminate
        color="purple"
      ></v-progress-circular>
    </v-snackbar>
    <v-card dark>
      <v-card-title primary-title>
        <div>
          <h3 class="headline mb-0">{{ card_detail.title }}</h3>
        </div>
      </v-card-title>
      <v-card-action>
        <input
          type="file"
          style=""
          multiple
          v-bind:ref="card_detail.ref"
          accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
          v-on:change="onFilePicked(card_detail.type,card_detail.ref)"
        >
        <v-btn 
          v-on:click="submit(card_detail.document)"
          block 
          color="blue-grey" 
          dark >
          Submit
        </v-btn>
      </v-card-action>
    </v-card>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        stockList : '',
        sectorIndustryCode : '',
        fundamentalData : '',
        snackbar: false,
        color: '',
        timeout: 0,
        text: 'Hello, I\'m a snackbar',
        uploading: true
      }
    },
    props : ['card_detail'],
    methods: {
      onFilePicked(type,ref) {
        let _ref = ref;
        if(type == "single") {
          this.stockList = this.$refs[ref].files[0];
          this.sectorIndustryCode = this.$refs[ref].files[0];
        } else if (type == "multiple") {
          this.fundamentalData = this.$refs[ref].files;
        }
        
      },

      submit(document) {
        let self = this;
        self.showUploadingSnackbar(self);
        var _formData = new FormData();

        if(document == "stockList"){

          _formData.append('file', this.stockList);
          _formData.append('filename', 'bursa_stock_list.csv');
          _formData.append('process', 'upload_bursa_stock_list');
         
        } else if(document == "sectorIndustryCode"){

          _formData.append('file', this.sectorIndustryCode);
          _formData.append('filename', 'sector_industry_code.csv');
          _formData.append('process', 'upload_sector_industry_code');
         
          
        } else if(document == "fundamentalData"){
          for(var i = 0; i < this.fundamentalData.length; i++){
            let _file = this.fundamentalData[i];

            _formData.append('file[' + i + ']', _file);
          }
          _formData.append('process', 'upload_fundamental_data');

        }
        axios({
          url: '/api/stocks',
          method: 'post',
          data: _formData,
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(function(response){
          console.log(response);
          if(response.data == "Failed Update Sector and Industry" || response.data == "Failed Update Stock List" || response.data == "Failed Update Fundamental Data") {
            self.showFailUploadSnackbar(self);

          } else if (response.data == "Update Sector and Industry Successfully" || response.data == "Update Stock List Successfully" || response.data == "Update Fundamental Data Successfully") {
            self.showSuccessUploadSnackbar(self);
          }
        })
        .catch(function(error){
          console.log(error.response);
        })
      },

      showFailUploadSnackbar(self){
        self.snackbar = true;
        self.uploading = false;
        self.color = 'error';
        self.text = "Failed Uploading";
        setTimeout(function() {
          self.snackbar = false;
        }, 2000);
      },

      showSuccessUploadSnackbar(self){
        self.snackbar = true;
        self.uploading = false;
        self.color = 'success';
        self.text = "Successed Uploading";
        setTimeout(function() {
          self.snackbar = false;
        }, 2000);
      },

      showUploadingSnackbar(self){
        self.snackbar = true;
        self.color = 'info';
        self.text = "Uploading...";
        self.uploading = true;
      },
    }
  }
</script>