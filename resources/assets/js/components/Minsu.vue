<template>
    <div>
       

              <div v-for="bar in bar2" class="row mb-1">
            <div class="class">
                <div class = "inline"><img src='https://i.imgur.com/Ruv9Uic.gif' width="100px"></div>
                    <div class="col-sm-20 pt-30">
                        <b-progress :value="bar.value" :variant="bar.variant" :key="bar.variant"></b-progress>
                    </div>
                </div>
            </div>

              <div v-for="bar in bar3" class="row mb-2">
            <div class="class">
                 <div class="col-sm-2">{{ bar.variant }}:</div>
      <div class="col-sm-10 pt-1">
        <b-progress :value="bar.value"
                    :variant="bar.variant"
                    :key="bar.variant"
        ></b-progress>
                    </div>
                </div>
            </div>
        </div>

        
    </template>

    <script>
        export default {
            data() {
                return {
                    bars: [
                        {
                            variant: 'minsu',
                            value: 0
                        }
                    ],
                     bar2: [
                        {
                            variant: 'minsu',
                            value: 0
                        }
                    ],
                     bar3: [
                        {
                            variant: 'minsu',
                            value: 0
                        }
                    ],
                    timer: null

                }
            },
          
            
             created() {
                this.timer = setInterval(() => {
                    this
                        .bar3
                        .forEach(bar => bar.value = 90)
                        
                }, 1000)
            },
             mounted() {
                this.timer = setInterval(() => {
                    this
                        .bar2
                        .forEach(bar => bar.value = 70)
                        
                }, 1000)
            },
            beforeDestroy() {
                clearInterval(this.timer)
                this.timer = null
            }
        }
    </script>
    <style>
        .inline {
            display: inline-block;
        }
    </style>