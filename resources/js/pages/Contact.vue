<template>

  <div id="contact" class="container">
    <h1>Contattaci</h1>

    <div class="row">

      <div class="col-12">

        <form @submit.prevent="sendForm">

          <!-- Alert corretto invio email se successSend è true -->
          <div class="alert alert-success" v-if="successSend">
              Email inviata!
          </div>

            <div class="form-group">
                <label for="name">Il tuo nome</label>
                <input type="text" class="form-control" :class=" {'is-invalid':errorsData.name} " id="name" name="name" v-model="name">
                
                <!-- ERRORI campo name -->
                <p class="invalid-feedback" v-for="(error, index) in errorsData.name" :key=" 'error_name' + index "> 
                  {{error}} 
                </p>

            </div>

            <div class="form-group">
                <label for="email">La tua email</label>
                <input type="email" class="form-control" :class=" {'is-invalid':errorsData.email} " id="email" name="email" v-model="email">
                
                <!-- ERRORI campo email -->
                <p class="invalid-feedback" v-for="(error, index) in errorsData.email" :key=" 'error_email' + index "> 
                  {{error}} 
                </p>
            
            </div>

            <div class="form-group">
                <label for="message">Scrivi il tuo messaggio</label>
                <textarea type="text" class="form-control" :class=" {'is-invalid':errorsData.message} " id="message" rows="5" name="message" v-model="message"></textarea>
            
                <!-- ERRORI campo Messaggio -->
                <p class="invalid-feedback" v-for="(error, index) in errorsData.message" :key=" 'error_message' + index "> 
                  {{error}} 
                </p>

            </div>

            <!-- durante l'invio del form scrivo Invio in corso... -->
            <button type="submit" class="btn btn-primary">{{sendingInProgress? 'Invio in corso...':'Invia'}}</button>

        </form>

      </div>

    </div>
    
  </div>

</template>

<script>

export default {
  name: 'Contact',

  data() {
    return {
      name: '',
      email: '',
      message: '',
      sendingInProgress: false,
      errorsData: {},
      successSend: false,
    }
  },

  methods: {
  
    sendForm() {

      this.sendingInProgress = true;

      //invio i valori inseriti nei campi input 
      axios.post('/api/contacts', {
          'name': this.name,
          'email': this.email,
          'message': this.message,
      }).then(response => {

          this.sendingInProgress = false;

          if (response.data.errors) {
            this.errorsData = response.data.errors;
            this.successSend = false;

          } else {

            //mostro così l'alert del corretto invio della mail
            this.successSend = true;

            //reset campi
            this.name = '',
            this.email = '',
            this.message = '',
            this.errorsData = {}
          
          };

      });

    }

  }
}

</script>

<style>

</style>