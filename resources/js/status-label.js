$(function() {
    $('.status-label').each(function() {
        var status = $(this).text().trim();

        switch (status) {
            case 'PENDING':
                $(this).addClass('text-yellow-400');
                break;
            case 'INPROGRESS':
                $(this).addClass('text-blue-500');
                break;
            case 'FINISHED':
                $(this).addClass('text-green-500');
                break;
            case 'DECLINED':
                $(this).addClass('text-red-500');
                break;
            default:
        }
    });
});
