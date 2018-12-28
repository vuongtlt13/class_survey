<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Database\Seeder;
use App\Http\Controllers\UserController;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserController::create_admin('admin', '1', 1);

        QuestionController::createTitle('Đánh giá môn học');
        QuestionController::createTitle('Nhận xét về công tác phục vụ');
        QuestionController::createTitle('Hoạt động giảng dạy của giáo viên');
        QuestionController::createTitle('Bản thân sinh viên');


        QuestionController::createQuestion(1, "Nội dung môn học thiết thực, hữu ích");
        QuestionController::createQuestion(1, "Nội dung giảng dạy vừa sức đối với tôi");
        QuestionController::createQuestion(1, "Mục tiêu của môn học nêu rõ kiến thức và kỹ năng người học cần đạt được");
        QuestionController::createQuestion(1, "Thời lượng môn học được phân bổ hợp lý cho các hình thức học tập");
        QuestionController::createQuestion(1, "Các tài liệu phục vụ môn học được cập nhật");
        QuestionController::createQuestion(1, "Bạn được hỗ trợ kịp thời trong quá trình học môn này");
        QuestionController::createQuestion(1, "Học phần môn học đã kích thích được tư duy sáng tạo");
        QuestionController::createQuestion(1, "Về tổng thể, tôi đánh giá học phần này ở mức độ tốt");

        QuestionController::createQuestion(2, "Giảng đường đáp ứng yêu cầu của môn học");
        QuestionController::createQuestion(2, "Các trang thiết bị tại giảng đường đáp ứng yêu cầu giảng dạy và học tập");
        QuestionController::createQuestion(2, "Giảng đương được chuẩn bị và phục vụ ở mức độ tốt");
        QuestionController::createQuestion(2, "Sỹ số lớp học hợp lý");
        QuestionController::createQuestion(2, "Thư viện đã phục vụ tốt cho nhu cầu tham khảo của học phần");
        QuestionController::createQuestion(2, "Về tổng thể, tôi đánh giá công tác phục vụ của học phần này ở mức độ tốt");
        
        QuestionController::createQuestion(3, "Giảng viên đã thiết kế, tổ chức học phần và sử dụng thời gian một cách khoa học, hợp lí");
        QuestionController::createQuestion(3, "Giảng viên đến lớp khi đã chuẩn bị tốt bài giảng");
        QuestionController::createQuestion(3, "Tôi cảm thấy hứng thú trong giờ học");
        QuestionController::createQuestion(3, "Bạn được hỗ trợ kịp thời trong quá trình học môn này");
        QuestionController::createQuestion(3, "Giảng viên đã tạo cơ hội cho sinh viên ứng dụng kiến thức lĩnh hội được");
        QuestionController::createQuestion(3, "Giảng viên đã hướng dẫn hiệu quả và thúc đẩy việc tự học của sinh viên");
        QuestionController::createQuestion(3, "Giảng viên khuyến khích sinh viên nêu câu hỏi và bày tỏ quan điểm riêng về các vấn đề của học phần");
        QuestionController::createQuestion(3, "Giảng viên thường nêu vấn đề để sinh viên suy nghĩ, tranh luận");
        QuestionController::createQuestion(3, "Giảng viên quan tâm tổ chức cho sinh viên tham gia hoạt động nhóm, thảo luận để giải quyết các nhiệm vụ học tập");
        QuestionController::createQuestion(3, "Giảng viên quan tâm đến giáo dục đạo đức, ý thức tổ chức kỉ luật cho người học");
        QuestionController::createQuestion(3, "Giảng viên đã sử dụng hiệu quả phương tiện dạy học");
        QuestionController::createQuestion(3, "Giảng viên tổ chức kiểm tra, đánh giá kết quả học tập của sinh viên đảm bảo tính trung thực, công bằng, phản ánh đúng năng lực của người học");
        QuestionController::createQuestion(3, "Giảng viên luôn thể hiện rõ sự nhiệt tình và tinh thần trách nhiệm cao trong giảng dạy");
        QuestionController::createQuestion(3, "Giảng viên thường xuyên lên lớp đúng giờ và thực hiện đúng lịch giảng dạy theo quy định");
        QuestionController::createQuestion(3, "Giảng viên thể hiện sự thân thiện, cởi mở trong giao tiếp với người học");
        QuestionController::createQuestion(3, "Giảng viên đề cập và nhấn mạnh những thông tin quan trọng một cách rõ ràng, dễ hiểu");
        QuestionController::createQuestion(3, "Giảng viên có hiểu biết sâu rộng về học phần/môn học");
        QuestionController::createQuestion(3, "Giảng viên đã tổ chức và kiểm soát tốt lớp học");
        QuestionController::createQuestion(3, "Giảng viên tôn trọng ý kiến của sinh viên");
        QuestionController::createQuestion(3, "Giảng viên đánh giá một cách công bằng quá trình học của sinh viên");
        QuestionController::createQuestion(3, "Về tổng thể, tôi đánh giá hoạt động giảng dạy của giảng viên ở mức độ tốt");

        QuestionController::createQuestion(4, "Tôi đã dành sự cố gắng hết sức cho môn học này");
        QuestionController::createQuestion(4, "Tôi đã lĩnh hội được những kiến thức cơ bản của học phần");
        QuestionController::createQuestion(4, "Tôi đã đạt được các kĩ năng thực hành có thể cần thiết cho tương lai");
        QuestionController::createQuestion(4, "Thông qua hoạt động  giảng dạy của giảng viên, tôi càng đánh giá cao giá trị của học phần này");
        QuestionController::createQuestion(4, "Tôi đã dành sự cố gắng hết sức cho môn học này");
        QuestionController::createQuestion(4, "Tôi muốn điểm môn học này đạt loại");
    }
}
