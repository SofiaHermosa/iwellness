<?php
    use App\IWellness\ProductClass;
    use App\IWellness\DashboardClass;
    use App\IWellness\WalletClass;
    use App\IWellness\DiamondConversionClass;
    use Illuminate\Support\Facades\DB;

    function ordinal($number) { 
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    function getProducts($id=null){
        $products = new ProductClass;
        $products->get($id)->data;

        return $products;
    }

    function getConversionItems($id=null){
        $items = new DiamondConversionClass;
        $items->get($id)->data;

        return $items;
    }

    function dashboardcontent($id=null){
        $dashboard = new DashboardClass($id);
        $dashboard->commissions()
        ->diamonds()
        ->earnings()
        ->capital()
        ->orders()
        ->cashin()
        ->cashout();

        return $dashboard;
    }

    function monthlyRecords($record,$id){
        $dashboard = new DashboardClass($id);
        $dashboard->monthlyRecords($record);

        return $dashboard;
    }

    function getCurrentWalletBalance($id){
        $wallet = new WalletClass();
        $wallet->getCurrentBalance($id);
        
        return $wallet->wallet ?? 0;
    }

    function dashboardChart($id=null){
        $dashboard = new DashboardClass($id);
        $dashboard->getFundRequestChart()->fundChart;

        return $dashboard;
    }

    function retriveAccountData($email){
        return DB::table('password_resets')
        ->select('*')
        ->join('users', 'users.email', '=', 'password_resets.email')
        ->where('password_resets.email', $email)
        ->orderBy('password_resets.created_at', 'DESC')
        ->first();
    }

    function maskEmail($email){
        $em   = explode("@",$email);
        $name = implode('@', array_slice($em, 0, count($em)-1));
        $len  = floor(strlen($name)/2);

        return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
    }
?>