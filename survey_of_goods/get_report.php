<?php require_once('../connection/conn.php'); ?>
<?php
    require "fpdf.php";
    
    class myPDF extends FPDF{
        function header(){
            $year=date('Y-m');
            //$this->Image('logo.png',10,6);
            $this->SetFont('Arial','B',18);
            $this->Cell(200,5,'PITABADDARA PUBLIC LIBRARY ('.$year.') SURVEY',0,0,'C');
            $this->Ln(20);
        }

        function footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','',8);
            $this->Cell(0,10,'page'.$this->PageNo().'/{nb}',0,0,'C');
        }
        
        function missing_table($admin_conn){
            $query="SELECT id,model,state,description FROM survey_book WHERE state='missing'ORDER BY id";
            $rquery=mysqli_query($admin_conn,$query);

            if ($rquery) {
                if (mysqli_num_rows($rquery)>0) {
                    $list_count=mysqli_num_rows($rquery);
                    $this->Cell(150,10,'Missing List ('.$list_count.')',0,1,'L');
                    $this->SetFont('Times','B',12);
                    $this->Cell(15,10,'id',1,0,'C');
                    $this->Cell(20,10,'model',1,0,'C');
                    $this->Cell(20,10,'state',1,0,'C');
                    $this->Cell(130,10,'description',1,1,'C');
                    $this->SetFont('Times','',12);
                    while ($detail=mysqli_fetch_assoc($rquery)) {
                        $this->Cell(15,10,$detail['id'],1,0,'L');
                        $this->Cell(20,10,$detail['model'],1,0,'L');
                        $this->Cell(20,10,$detail['state'],1,0,'L');
                        $query="SELECT name,price FROM book WHERE id='{$detail['id']}' limit 1";
                        $result_query=mysqli_query($admin_conn,$query);
                        $name='';
                        $price='';
                        if ($result_query) {
                            while ($book_detail=mysqli_fetch_assoc($result_query)) {
                                $name=$book_detail['name'];
                                $price=$book_detail['price'];
                            }
                        }
                        $this->Cell(130,10,$detail['description'].', book name: '.$name.', price: '.$price,1,1,'L');
                    }
                }
            }
            $this->Ln(20);
        }
        function transaction_table($admin_conn){
            //geting transaction book...
            $query="SELECT id,model,state,description FROM survey_book WHERE state='transaction'ORDER BY id";
            $rquery=mysqli_query($admin_conn,$query);

            if ($rquery) {
                if (mysqli_num_rows($rquery)>0) {
                    $list_count=mysqli_num_rows($rquery);
                    //transaction list table create...
                    $this->SetFont('Arial','B',14);
                    $this->Cell(150,10,'Transaction List ('.$list_count.')',0,1,'L');
                    $this->SetFont('Times','B',12);
                    $this->Cell(15,10,'id',1,0,'C');
                    $this->Cell(20,10,'model',1,0,'C');
                    $this->Cell(20,10,'state',1,0,'C');
                    $this->Cell(130,10,'description',1,1,'C');
                    $this->SetFont('Times','',12);
                   
                    //while loop...
                    while ($detail=mysqli_fetch_assoc($rquery)) {
                        $book_id=$detail['id'];
                        $trance="SELECT member_id,due_date from transactions where book_id='{$book_id}'";
                        $rtrance=mysqli_query($admin_conn,$trance);
                        if ($rtrance) {
                            while ($get=mysqli_fetch_assoc($rtrance)) {
                                $member_id=$get['member_id'];
                                $sdue_date=$get['due_date'];
                                $stoday=date('Y-m-d');
                                $today=date_create($stoday);
                                $due_date=date_create($sdue_date);
                                $diff=date_diff($due_date,$today);
                                //echo $diff->format("%R%a days");
                                if ($diff->format("%R%a")<=365) {
                                    $this->Cell(15,10,$detail['id'],1,0,'L');
                                    $this->Cell(20,10,$detail['model'],1,0,'L');
                                    $this->Cell(20,10,$detail['state'],1,0,'L');
                                    $this->Cell(130,10,$detail['description'],1,1,'L');
                                }
                            }
                        }
                        
                    }
                }
                
            }
            $this->Ln(20);
        }
        function long_time_transaction($admin_conn){
            //geting transaction book...
            $query="SELECT id,model,state,description FROM survey_book WHERE state='transaction'ORDER BY id";
            $rquery=mysqli_query($admin_conn,$query);

            if ($rquery) {
                if (mysqli_num_rows($rquery)>0) {
                     //transaction list of long time transaction table create...
                    $this->SetFont('Arial','B',13);
                    $this->Cell(150,10,'long time transaction list',0,1,'L');
                    $this->SetFont('Times','B',12);
                    $this->Cell(15,10,'id',1,0,'C');
                    $this->Cell(20,10,'model',1,0,'C');
                    $this->Cell(20,10,'state',1,0,'C');
                    $this->Cell(130,10,'description',1,1,'C');
                    $this->SetFont('Times','',12);
                    //while loop...
                    while ($detail=mysqli_fetch_assoc($rquery)) {
                        $book_id=$detail['id'];
                        $trance="SELECT member_id,due_date from transactions where book_id='{$book_id}'";
                        $rtrance=mysqli_query($admin_conn,$trance);
                        if ($rtrance) {
                            while ($get=mysqli_fetch_assoc($rtrance)) {
                                $member_id=$get['member_id'];
                                $sdue_date=$get['due_date'];
                                $stoday=date('Y-m-d');
                                $today=date_create($stoday);
                                $due_date=date_create($sdue_date);
                                $diff=date_diff($due_date,$today);
                                //echo $diff->format("%R%a days");
                                if ($diff->format("%R%a")>365) {
                                    $this->Cell(15,10,$detail['id'],1,0,'L');
                                    $this->Cell(20,10,$detail['model'],1,0,'L');
                                    $this->Cell(20,10,$detail['state'],1,0,'L');
                                    $this->Cell(130,10,$detail['description'],1,1,'L');
                                }
                            }
                        }
                        
                    }
                }
            }
            $this->Ln(20);
        }
        function here_list($admin_conn){
            $here_list='';
            $query="SELECT id,model,state,description FROM survey_book WHERE state='here' ORDER BY id";
            $rquery=mysqli_query($admin_conn,$query);
            if ($rquery) {
                $list_count=mysqli_num_rows($rquery);
                //here list table create...
                $this->SetFont('Arial','B',14);
                $this->Cell(150,10,'In Library List ('.$list_count.')',0,1,'L');
                $this->SetFont('Times','B',12);
                $this->Cell(15,10,'id',1,0,'C');
                $this->Cell(20,10,'model',1,0,'C');
                $this->Cell(20,10,'state',1,0,'C');
                $this->Cell(130,10,'description',1,1,'C');
                $this->SetFont('Times','',12);
                while ($detail=mysqli_fetch_assoc($rquery)) {
                    $this->Cell(15,10,$detail['id'],1,0,'L');
                    $this->Cell(20,10,$detail['model'],1,0,'L');
                    $this->Cell(20,10,$detail['state'],1,0,'L');
                    $this->Cell(130,10,$detail['description'],1,1,'L');
                }
            }
            $this->Ln(20);
        }
        function total_count($admin_conn){
            $query="SELECT id FROM survey_book";
            $rquery=mysqli_query($admin_conn,$query);
            if ($rquery) {
                $count=mysqli_num_rows($rquery);
                $this->SetFont('Arial','B',14);
                $this->Cell(150,10,'Totale Book Count Is ('.$count.')',0,1,'L');
            }
        }
    }

    $pdf = new myPDF('p','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->missing_table($admin_conn);
    $pdf->transaction_table($admin_conn);
    $pdf->long_time_transaction($admin_conn);
    $pdf->here_list($admin_conn);
    $pdf->total_count($admin_conn);
    $pdf->Output();
?>