<?php

use Illuminate\Database\Seeder;

class RegistrationQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $record_id = DB::table('registrations_questions')->insertGetId([
            'question_text' => "What is your monthly income expectation from MENU dealers?",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "ما هو الدخل المتوقع؟",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       $record_id = DB::table('registrations_questions')->insertGetId([
            'question_text' => "Do you have any other business?",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "هل لديك عمل آخر؟",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       $record_id = DB::table('registrations_questions')->insertGetId([
            'question_text' => "Who will make the financial investment?",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "من سيقوم بالاستثمار المالي؟",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       $record_id = DB::table('registrations_questions')->insertGetId([
            'question_text' => "Have you been a dealer before?",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "هل قمت بالاشتراك مسبقا؟",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       $record_id = DB::table('registrations_questions')->insertGetId([
            'question_text' => "Your current monthly net income?",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "الدخل الشهري؟",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       $record_id = DB::table('registrations_questions')->insertGetId([
            'question_text' => "Why do you want to become a MENU dealer?",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "هل ترغب بالاشتراك حقا؟",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       
       $record_id =DB::table('registrations_questions')->insertGetId([
            'question_text' => "Which city do you want to be a dealership?",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "في اي مدينة تود الاشتراك؟",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       
       $record_id =DB::table('registrations_questions')->insertGetId([
            'question_text' => "Which location do you want to be a dealership?",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);

        DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "في اي منطقة تود الاشتراك؟",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       
       $record_id =DB::table('registrations_questions')->insertGetId([
            'question_text' => "Which district do you want to be a dealership?",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);

       DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "في اي مقاطعة تود الاشتراك؟",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
       $record_id =DB::table('registrations_questions')->insertGetId([
            'question_text' => "confirm the accuracy of the above information provided to Menu. I allow access to me through this information I provide to MENU. MENU will only use this information to evaluate your application. Your information will not be shared with others.",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);

       
        DB::table('translations')->insert([
            'model' => "registrations_questions",
            'field' => "question_text",
            'record_id' =>$record_id,
            'language_id' => "ar",
            'display_text' => "تأكيد دقة المعلومات المذكورة أعلاه المقدمة إلى القائمة. أسمح بالوصول إلي من خلال هذه المعلومات التي أقدمها لـ MENU. سوف تستخدم MENU هذه المعلومات فقط للتقييم التطبيق الخاص بك. لن يتم مشاركة معلوماتك مع الآخرين.",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
    }
}
