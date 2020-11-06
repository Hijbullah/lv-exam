<template>
    <app-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col justify-center items-center">
                    <h2 class="font-bold uppercase tracking-widest">{{ exam.exam_type }}: {{ exam.name }}</h2>
                    <p>Marks: {{ exam.total_question }}</p>
                    <p>Time: {{ exam.duration }}</p>
                </div>
                <div class="w-2/3 mx-auto mt-12">
                    <div v-if="!isExamFinish">
                        <div class="flex justify-end items-center">
                            <the-timer 
                                :duration="exam.duration" 
                                @times-up="examTimeEnded"
                            />
                        </div>
                        <div class="mt-6">
                            <p class="text-xl font-bold"><span>{{ currenQuestion.serial }}.</span> {{ currenQuestion.question }}</p>
                            <div class="mt-3 pl-8 space-y-1">
                                <div v-for="(option, key, index) in currenQuestion.options" :key="index" class="flex items-center">
                                    <input v-model="selectedOption" :value="key" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                    <p class="ml-2">{{ key }})<p>
                                    <p class="ml-2">
                                        {{ option }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-12">
                            <div class="space-x-2">
                                <button 
                                    @click.prevent="setNeverQuestion"
                                    class="px-3 py-1 bg-red-700 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-red-600 focus:outline-none"
                                >Skip</button>
                                <button 
                                    @click.prevent="setLaterQuestion"
                                    class="px-3 py-1 bg-yellow-500 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-yellow-400 focus:outline-none"
                                >Later</button>
                                <button 
                                    @click.prevent="selectAnswer"
                                    :disabled="!this.selectedOption"
                                    class="px-3 py-1 bg-indigo-700 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-indigo-600 focus:outline-none disabled:opacity-50"
                                >Next</button>
                            </div>
                            <button 
                                @click.prevent="finishExam"
                                class="px-3 py-1 bg-green-600 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-green-500 focus:outline-none"
                            >Finish</button>
                        </div>
                    </div>
                    <div v-else>
                        exam finish
                    </div>
                </div>
                <div class="flex justify-center items-center mt-12 divide-x-2 divide-y-2">
                    <div
                        v-for="question in questions"
                        :key="question.serial"  
                        :class="question.cssClass"
                        class="h-8 w-8 flex justify-center items-center font-semibold rounded-full border-2 border-gray-900"
                    >{{ question.serial }}</div>
                </div>
                <p class="mt-12 text-center text-red-600 font-semibold">* Don't Reload, close or minimize the brower or Change the Tab. Exam will autometically end if you do that.</p>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import TheTimer from './TheTimer'

    export default {
        components: {
            AppLayout,
            TheTimer
        },
        props: ['exam'],
        data() {
            return {
                removeStartEventListener: null,
                isExamFinish: false,

                selectedOption: null,
                neverQuestion: 0,

                questions: [],
                questionData: [],
                laterQuestions: [],
                currenQuestion: [],
                answerSheet: [],
            }
        },

        methods: {
            // select answer
            selectAnswer(answer) {
                this.answerSheet.push({
                    id: this.currenQuestion.id,
                    answer: this.selectedOption,
                });
                this.changeQuestonStatus('selected');
                this.selectedOption = null;
                this.getNextQuestion();
            },

            // next question
            getNextQuestion() {
                if(this.questionData.length >=1) {
                    this.currenQuestion = this.questionData.pop();
                }else if(this.laterQuestions.length >= 1) {
                    this.questionData = this.laterQuestions.reverse();
                    this.laterQuestions = [];
                    this.currenQuestion = this.questionData.pop();
                }else{
                    this.finishExam();
                }
            },

            // later
            setLaterQuestion() {
                this.selectedOption = null;
                this.laterQuestions.push(this.currenQuestion);
                this.changeQuestonStatus('later');
                this.getNextQuestion();
            },

            //never
            setNeverQuestion() {
                this.selectedOption = null;
                this.neverQuestion += 1;
                this.changeQuestonStatus('skip');
                this.getNextQuestion();
            },

            // finish
            finishExam() {
                this.removeStartEventListener();

                this.$inertia.post(route('app.exams.finish', this.exam.exam_id), {
                        answerSheet: this.answerSheet
                    },{
                    onSuccess: ( page ) => {
                        this.isExamFinish = true;
                    }
                });
            },

            examTimeEnded() {
                //this.finishExam();
            },
            changeQuestonStatus(status) {
                let question = this.questions.find(question => question.serial == this.currenQuestion.serial);
                if(status == 'selected') {
                    question.cssClass = 'bg-green-600 text-white';
                } else if(status == 'skip') {
                    question.cssClass = 'bg-red-600 text-white';
                } else {
                    question.cssClass = 'bg-yellow-600 text-white';
                }
            }
        },

        mounted() {
            this.questions = this.exam.questions.map((question, index) => {
                question['serial'] = index + 1; 
                question['cssClass'] = '';
                return question;
            });

            this.questionData = Array.from(this.questions);

            this.questionData = this.questionData.reverse();
            this.currenQuestion = this.questionData.pop();

            this.$once(
                'hook:destroyed',
                this.removeStartEventListener = this.$inertia.on('start', (event) => {
                    if (!confirm('Want to navigate away, Are you sure? Your exam will end autometically')) {
                        event.preventDefault();
                    }
                })
            );

            // document.addEventListener("visibilitychange", this.logSomething)
            //     this.$once("hook:beforeDestroy", () => {
            //     document.removeEventListener("visibilitychange", this.logSomething);
            // });
        },
        
    }
</script>
