/* 
 * filter by year and subject
 */
$(function(){
   

   $('#filterForm select').change(function() {
        var value   = $(this).val(),
            url     = $('#filterForm').attr('action'),
            subject = $('#WallPost_subject'),
            year    = $('#WallFilter_time_date_year');
        
        if(subject)
        {
            //check if years already set
            if(year)
            {

                $('#filterForm').attr('action', url + '/' + year.val());
                
            }
            //check subject
            $('#filterForm').attr('action', url + '/' + value);
            $('#filterForm').submit();
         
        }
        
        
        
    });

});



