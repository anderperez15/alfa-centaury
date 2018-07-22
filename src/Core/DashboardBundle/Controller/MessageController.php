<?php

namespace Core\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Core\DashboardBundle\Entity\Message;
use Core\DashboardBundle\Entity\Solicitante;
use Core\DashboardBundle\Entity\MessageAttachment;
use Core\DashboardBundle\Entity\MessageHistorial;
use Core\DashboardBundle\Entity\MessageHistorialAttachment;
use Ddeboer\DataImport\Reader\CsvReader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Core\DashboardBundle\Form\SolicitanteType;
use Symfony\Component\HttpFoundation\Response;
use PHPExcel;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends Controller
{
    public function writeAction()
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $demands = $em->getRepository("CoreDashboardBundle:Demand")->findAll();
        
        return $this->render('CoreDashboardBundle:Message:new.html.twig',array('user'=>$user,'demands'=>$demands));
    }
    
     private function generateRandomString(){

        $em = $this->getDoctrine()->getManager();
        $qb= $em->createQueryBuilder();
        $qb->select('MAX(t.code)')
            ->from('CoreDashboardBundle:Message', 't');
        $ticketId=$qb->getQuery()
            ->getOneOrNullResult();
        $current_ticket=NULL;
        $nuevo_ticket=NULL;

        foreach ($ticketId as $t) {
            $current_ticket=$t;
        }

        if(is_null($current_ticket)){
            $nuevo_ticket=str_pad($current_ticket+1, 10, "0", STR_PAD_LEFT);
        }else{
            $nuevo_ticket=str_pad($current_ticket+1, 10, "0", STR_PAD_LEFT);
        }

        return $nuevo_ticket;
    }


   private function generateRandomString2(){

	$codigoverificacion =   md5(mt_rand(1,30));


	$pattern = "1234567890abcdefghijklmnopqrstuvwxyz"; 

	    for($i = 0; $i < 8; $i++) { 
	
        	$key .= $pattern{rand(0, 35)}; 

	    } 


        return $key;
    }


    

    public function createAction(Request $request,  \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $data = $request->request;
        $SID1 = $data->get('numdoc');
        $SID = $data->get('documento');
//echo $SID;exit;
        $solicitante_e = $em->getRepository("CoreDashboardBundle:Solicitante")->findOneBy(array("documento"=>$SID));

        $demandID = $data->get('demandType');
        $adress = $data->get('adress');
        $mail= $data->get('mail');
        if(!empty($adress))
        {
          $solicitante_e->setDireccion($adress);
          $em->persist($solicitante_e);
        }
         if(!empty($mail))
        {
          $solicitante_e->setCorreo($mail);
          $em->persist($solicitante_e);
        }
        $demand = $em->getRepository("CoreDashboardBundle:Demand")->find($demandID);
        $contactType = $data->get('contactType');
        $subject = $data->get('subject');
        $body = $data->get('message');
        $SolID1 = $data->get('numdoc');
	 $SolID = $data->get('documento');

//        $solicitante = $em->getRepository("CoreDashboardBundle:Solicitante")->findByDocumento($SolID);
$solicitante = $em->getRepository("CoreDashboardBundle:Solicitante")->findOneBy(array("documento"=>$SolID));
$idsol =  $solicitante->getId();

        $code = $this->generateRandomString();
        $verificacion = $this->generateRandomString2();

        $message  = new Message();
        $message->setContactType($contactType);
        $message->setCreatedBy($solicitante);
        $message->setDemandType($demand);
        $message->setMessage($body);
        $message->setSubject($subject);
        $message->setCode($code);
        $message->setVerification($verificacion);

        $em->persist($message);
        $em->flush();
        
        $files = $request->files->get('attachments');
        $files1 = $request->files->get('attachments1');
        $files2 = $request->files->get('attachments2');
        foreach ($files as $file)
        {
            if($file !=NULL)
            {
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $type = $file->getClientMimeType();
                $size = $file->getClientSize();
                $path = "request_".$message->getId()."_".$name;



	        $nombrearchivo = $em->getRepository("CoreDashboardBundle:MessageAttachment")->findByPath($path);

            if(!nombrearchivo){		
                $file->move("attachments/",$path);                
                $messageAttachment = new MessageAttachment();
                $messageAttachment->setAttachType($type);
                $messageAttachment->setExtension($extension);
                $messageAttachment->setMessageID($message);
                $messageAttachment->setPath($path);
                $messageAttachment->setSize($size);
                $em->persist($messageAttachment);
                $em->flush();
		}
            }
           
        }
        
         foreach ($files1 as $file)
        {
            if($file !=NULL)
            {
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $type = $file->getClientMimeType();
                $size = $file->getClientSize();
                $path = "request_".$message->getId()."_".$name;
                


                $nombrearchivo = $em->getRepository("CoreDashboardBundle:MessageAttachment")->findByPath($path);

            if(!nombrearchivo){
                $file->move("attachments/",$path);

                $messageAttachment = new MessageAttachment();
                $messageAttachment->setAttachType($type);
                $messageAttachment->setExtension($extension);
                $messageAttachment->setMessageID($message);
                $messageAttachment->setPath($path);
                $messageAttachment->setSize($size);
                $em->persist($messageAttachment);
                $em->flush();
} //CIERRE DE VERIFICACION DE ARCHIVO
            }
           
        }
        
         foreach ($files2 as $file)
        {
            if($file !=NULL)
            {
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $type = $file->getClientMimeType();
                $size = $file->getClientSize();
                $path = "request_".$message->getId()."_".$name;




                $nombrearchivo = $em->getRepository("CoreDashboardBundle:MessageAttachment")->findByPath($path);

            if(!nombrearchivo){

                $file->move("attachments/",$path);                
                $messageAttachment = new MessageAttachment();
                $messageAttachment->setAttachType($type);
                $messageAttachment->setExtension($extension);
                $messageAttachment->setMessageID($message);
                $messageAttachment->setPath($path);
                $messageAttachment->setSize($size);
                $em->persist($messageAttachment);
                $em->flush();
		} //FIN DE VERIFICAR ARCHIVOS
            }
           
        }
        
        
//        $this->get('session')->getFlashBag()->add('notice', 'Su petición fue registada con el No. '.$code.' y será atendida en días hábiles contados a  partir de la fecha de radicación');
       $this->get('session')->getFlashBag()->add("notice","Se guardó un nuevo registro No. ".$code.". Por favor guarde este código de verificación <span style='color:blue'>".$verificacion."</span> para consultas posteriores de este radicado.");
        $url = $this->generateUrl('my_messages');
        $response = new RedirectResponse($url);

        $message = (new \Swift_Message('Registro PQRD'))
        ->setFrom('hermelopezp@gmail.com')
        ->setTo($mail)
        ->setBody(
            $this->renderView(
                'Emails/pqrd_registro.html.twig',
                [
                    "nombre" => "valor",
                    "apellido" => "valor",
                    "codigo" => $code,
                    "dia" => "valor",
                    "mes" => "valor",
                    "year" => "valor"
                ]
            ),
            'text/html'
        );

        $mailer->send($message);

        return $response;        
        
    }
    public function listAction(Request $request)
    {
        
        $user = $this->container->get('security.context')->getToken()->getUser();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('solicitante_listado'))
            ->setMethod('POST')
            ->add('documento', 'text', array('label' => 'Documento'))
            ->getForm();
        $form->add('submit', 'submit', array('label' => 'Buscar'));

        if ($request->getMethod('post') == 'POST') {
            $em = $this->getDoctrine()->getManager();

            $form->handleRequest($request);

            $solicitante = $em->getRepository('CoreDashboardBundle:Solicitante')->findOneBy(array('documento'=>$form->get('documento')->getData()));


            if(is_null($solicitante)){

                $this->addFlash('danger', 'Este documento no existe!');
                return $this->redirect($this->generateUrl('solicitante_inicio'));
            }
            $myMessages = $em->getRepository("CoreDashboardBundle:Message")->findBy(array('createdBy'=>$solicitante->getId()),array('createdOn' => 'ASC'));


            $paginator = $this->get('knp_paginator');

                     $demands = $em->getRepository("CoreDashboardBundle:Demand")->findOneBy(array('demandType' => 'Petición en interés general y particular'));
            $nbdayspet = $demands->getNbDaysTreatement();
            
			$demands = $em->getRepository("CoreDashboardBundle:Demand")->findOneBy(array('demandType' => 'Petición de Información'));
            $nbdaysinf = $demands->getNbDaysTreatement();

	        $demands = $em->getRepository("CoreDashboardBundle:Demand")->findOneBy(array('demandType' => 'Petición de Documentación'));
            $nbdaysdoc = $demands->getNbDaysTreatement();
		
            $demands = $em->getRepository("CoreDashboardBundle:Demand")->findOneBy(array('demandType' => 'Quejas'));
            $nbdaysq = $demands->getNbDaysTreatement();

            $demands = $em->getRepository("CoreDashboardBundle:Demand")->findOneBy(array('demandType' => 'Reclamos'));
            $nbdaysrec = $demands->getNbDaysTreatement();

            $demands = $em->getRepository("CoreDashboardBundle:Demand")->findOneBy(array('demandType' => 'Sugerencias'));
            $nbdayssug = $demands->getNbDaysTreatement();
            
            $pagination = $paginator->paginate($myMessages, $request->query->getInt('page', 1), 10);
            $datenow = date('Y-m-d');

            $colors = array();
            foreach ($myMessages as $msg) {
                if ($msg->getDemandType()->getDemandType() == 'Petición en interés general y particular')
                    $nbdays = $nbdayspet;
                else if ($msg->getDemandType()->getDemandType() == 'Petición de Información')
                    $nbdays = $nbdaysinf;	
                else if ($msg->getDemandType()->getDemandType() == 'Petición de Documentación')
                    $nbdays = $nbdaysdoc;					
                else if ($msg->getDemandType()->getDemandType() == 'Quejas')
                    $nbdays = $nbdaysq;
                else if ($msg->getDemandType()->getDemandType() == 'Reclamos')
                    $nbdays = $nbdaysrec;
                else if ($msg->getDemandType()->getDemandType() == 'Sugerencias')
                    $nbdays = $$nbdayssug;

                $creationDate = date_format($msg->getCreatedOn(), ('Y-m-d'));
                $Dateresp = strtotime(date('Y-m-d', strtotime('+' . $nbdays . ' days', strtotime($creationDate))));
                $Datenow = strtotime($datenow);
                $diff = ($Dateresp - $Datenow) / 60 / 60 / 24;
                if ($nbdays == 10) {
                    if ($diff >= 5)
                        $colors[$msg->getId()] = 'green';
                    else if ($diff >= 3 && $diff <= 4)
                        $colors[$msg->getId()] = 'orange';
                    else if ($diff <= 2)
                        $colors[$msg->getId()] = 'red';
                }
                if ($nbdays == 15) {
                    if ($diff >= 8)
                        $colors[$msg->getId()] = 'green';
                    else if ($diff >= 4 && $diff <= 7)
                        $colors[$msg->getId()] = 'orange';
                    else if ($diff <= 3)
                        $colors[$msg->getId()] = 'red';
                }
                if ($nbdays == 30) {
                    if ($diff >= 15)
                        $colors[$msg->getId()] = 'green';
                    else if ($diff >= 8 && $diff <= 14)
                        $colors[$msg->getId()] = 'orange';
                    else if ($diff <= 7)
                        $colors[$msg->getId()] = 'red';
                }

            }
//              print_r($colors);die;


            return $this->render('CoreDashboardBundle:Message:list.html.twig', array('user' => $user, 'messages' => $pagination, 'colors' => $colors));
        }
        return $this->redirect($this->generateUrl('solicitante_inicio'));
        }


    public function documentocodigoAction(Request $request){

            $id = $_POST['idprincipal'];
            $codigo = $_POST['codigo'];
            $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM CoreDashboardBundle:Message p
        WHERE p.id = $id and p.verification = '$codigo' "
        );
        $result = $queryc->getResult();

$generardatos = false;
if(count($result)>0){
        $generardatos = true;
}

 return new JsonResponse($generardatos);

    }


    public function viewAction(Request $request)
    {
	$codigogenerado = $_POST["codigogenerado"];
        $id = $_POST["idmensaje"];
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $message = $em->getRepository("CoreDashboardBundle:Message")->findOneBy(array("id"=>$id,"verification"=>$codigogenerado));
//        $solicitante_e = $em->getRepository("CoreDashboardBundle:Solicitante")->findOneBy(array("documento"=>$SID));
        
        $historial = $message->getHistorial();
        $paginator  = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate($historial, $request->query->getInt('page', 1),10);
   
        return $this->render('CoreDashboardBundle:Message:view.html.twig',array('historials'=>$pagination,'message'=>$message));
    }

	public function consultaAction(){
		echo "vista nueva";
exit;

	}
    
    public function internalAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $service = $user->getDependecyID()->getName();
        if($user->getIsBoss())
        {
          $query = $em->createQuery("SELECT m FROM CoreDashboardBundle:Message m
                                        ORDER BY m.createdOn DESC"); //->setParameter("service",$service);
          $messages = $query->getResult();                              
        }
        else
        {
            $query = $em->createQuery("SELECT m FROM CoreDashboardBundle:Message m
                                          WHERE m.canBeViewed = 1
                                          AND m.canBeViewedBy =:id
                                          ORDER BY m.createdOn DESC")->setParameters(array("id"=>$user->getId()));
            $messages = $query->getResult();    
            
        }
       // $paginator  = $this->get('knp_paginator');
       // $pagination = $paginator->paginate($messages, $request->query->getInt('page', 1),10);
        
        return $this->render('CoreDashboardBundle:Message:inbox_internal.html.twig',array('user'=>$user,'messages'=>$messages));
    }
    public function treatAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $message = $em->getRepository("CoreDashboardBundle:Message")->find($id);
        if(!$message->getIsViewed())
        {
            $message->setViewedBy($user);
        }
        $service =$message->getCurrentService();
        
        
        $services = $em->createQuery("SELECT g.name FROM CoreUsersBundle:Group g")
                        ->getResult();
        $message->setIsViewed(TRUE);
        $message->setStatus("En Tramite");
        $em->persist($message);
        $em->flush();
        
        $users = $this->getusersService($user->getDependecyID()->getID());
        return $this->render('CoreDashboardBundle:Message:treat.html.twig',array('user'=>$user,'message'=>$message,'services'=>$services,'users'=>$users));
    }
    public function moveAction($id,Request $request)
    {
        $data = $request->request;
        $service = $data->get('toservice');
        $radicado=$data->get('nradicado');
        $fechar=$data->get('FecRa');
        $deber=$data->get('FecCi');
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $message = $em->getRepository("CoreDashboardBundle:Message")->find($id);
        $oldService = $message->getCurrentService();
        $message->setCurrentService($service);
        $message->setCanBeViewed(FALSE);
        $message->setRadicado($radicado);
        $message->setFecRa(new \DateTime($fechar));
        $message->setAntesD(new \DateTime($deber));
        $em->persist($message);
        $em->flush();
        
        $textResponse = $data->get('textResponse');
        $messageHistorial = new MessageHistorial();
        $messageHistorial->setMessageID($message);
        $messageHistorial->setMessageStatus($message->getStatus());
        $messageHistorial->setServiceFrom($oldService);
        $messageHistorial->setServiceTo($service);
        $messageHistorial->setTextResponse($textResponse);
        $messageHistorial->setUserSender($user);
        //$receiver = $this->getBossDependence($service);
        //$id=14;
        //$user->getuserId($id);
        $messageHistorial->setUserReceiver($user);
        $messageHistorial->setAction('Cambio de Area');
        $em->persist($messageHistorial);
        $em->flush();

        $files = $request->files->get('attachments');
        foreach ($files as $file)
        {
            if($file !=NULL)
            {
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $type = $file->getClientMimeType();
                $size = $file->getClientSize();
                $path = "historial_".$messageHistorial->getId()."_request_".$message->getId()."_".$name;
                $file->move("attachments/",$path);
                
                $messageHistorialAttachment = new MessageHistorialAttachment();
                $messageHistorialAttachment->setAttachType($type);
                $messageHistorialAttachment->setExtension($extension);
                $messageHistorialAttachment->setMessageHistorialID($messageHistorial);
                $messageHistorialAttachment->setPath($path);
                $messageHistorialAttachment->setSize($size);
                $em->persist($messageHistorialAttachment);
                $em->flush();
            }
           
        }
        
        
        $this->get('session')->getFlashBag()->add('moveRequest', 'Solicitud para el area de '.$service.' correctamente !! ');
        $url = $this->generateUrl('messages_internals');
        $response = new RedirectResponse($url);
        return $response;
    }
    public function shareAction($id,Request $request)
    {
        $data = $request->request;
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $share = $data->get("share");
        $receiverID = $data->get('receiverID');
        if($receiverID !=NULL)
        {
           $receiver = $em->getRepository("CoreUsersBundle:User")->find($receiverID);    
        }
        
        $message = $em->getRepository("CoreDashboardBundle:Message")->find($id);
        $message->setCanBeViewed($share);
        if($receiverID !=NULL)
        {
           $message->setCanBeViewedBy($receiver);     
        }
        else $message->setCanBeViewedBy(NULL);
       
        $em->persist($message);
        $em->flush();
        
        
        $service = $message->getCurrentService();
        $textResponse = $data->get('textResponse');
        $messageHistorial = new MessageHistorial();
        $messageHistorial->setMessageID($message);
        $messageHistorial->setMessageStatus($message->getStatus());
        $messageHistorial->setServiceFrom($service);
        $messageHistorial->setServiceTo($service);
        $messageHistorial->setTextResponse($textResponse);
        $messageHistorial->setUserSender($user);
        if($receiverID !=NULL)
        {
          $messageHistorial->setUserReceiver($receiver);
        }
        if($share)
        {
           $messageHistorial->setAction('share');    
        }
        else
        {
            $messageHistorial->setAction('disable sharing');
        }
        
        $em->persist($messageHistorial);
        $em->flush();
        
        $files = $request->files->get('attachments');
        foreach ($files as $file)
        {
            if($file !=NULL)
            {
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $type = $file->getClientMimeType();
                $size = $file->getClientSize();
                $path = "historial_".$messageHistorial->getId()."_request_".$message->getId()."_".$name;
                $file->move("attachments/",$path);
                
                $messageHistorialAttachment = new MessageHistorialAttachment();
                $messageHistorialAttachment->setAttachType($type);
                $messageHistorialAttachment->setExtension($extension);
                $messageHistorialAttachment->setMessageHistorialID($messageHistorial);
                $messageHistorialAttachment->setPath($path);
                $messageHistorialAttachment->setSize($size);
                $em->persist($messageHistorialAttachment);
                $em->flush();
            }
           
        }
        
        if ($share)
        {
            $notice = "Request shared with other dependence users successfully.";
        }
        else
        {
            $notice = "The sharing of this request has been disabled with other dependence users successfully.";
        }
        $this->get('session')->getFlashBag()->add('shareRequest', $notice);
        $url = $this->generateUrl('messages_internals');
        $response = new RedirectResponse($url);
        return $response;
    }
    public function closeAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $today = new \DateTime('now');
        $message = $em->getRepository("CoreDashboardBundle:Message")->find($id);
        $data = $request->request;
        $responseText = $data->get('responseText');
        $encuesta = $data->get('encuesta');
        $message->setIsTreated(TRUE);
        $message->setStatus('Cerrado');
        $message->setClosedOn($today);
        $message->setResponseText($responseText);
        $message->setClosedBy($user);
        $message->setEncuesta($encuesta);
        
        $em->persist($message);
        $em->flush();
        
        $service = $message->getCurrentService();
        $messageHistorial = new MessageHistorial();
        $messageHistorial->setMessageID($message);
        $messageHistorial->setMessageStatus($message->getStatus());
        $messageHistorial->setServiceFrom($service);
        $messageHistorial->setServiceTo($service);
        $messageHistorial->setTextResponse($responseText);
        $messageHistorial->setUserSender($user);
        $messageHistorial->setUserReceiver($user);
        $messageHistorial->setAction('Cerrado');    
        $em->persist($messageHistorial);
        $em->flush();
        
        
        //SEND EMAIL TO THE EXTERNAL
        /*
         if($message->getContactType()==='mail')
         { 
                $mail = \Swift_Message::newInstance()
                        ->setSubject("Your request has been treated and closed ")
                        ->setFrom('safwen.bensalem@mapp-net.com')
                        ->setTo($message->getCreatedBy()->getEmail())
                        ->setContentType("text/html")
                        ->setBody('CoreDashboardBundle:Message:mail.html.twig',array('message'=>$message))
                        ;
               $this->get('mailer')->send($mail);
         }
         */
        
        $this->get('session')->getFlashBag()->add('closeRequest', 'Peticion cerrada corretamente. !! ');
        $url = $this->generateUrl('messages_internals');
        $response = new RedirectResponse($url);
        return $response;
        
    }
    
    public function typeAction(Request $request, $type)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $messages = $em->createQuery("SELECT m FROM CoreDashboardBundle:Message m
                                      WHERE m.status =:status
                                      ORDER BY m.createdOn DESC")->setParameter("status",$type);
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($messages, $request->query->getInt('page', 1),10);
        
        return $this->render('CoreDashboardBundle:Message:type.html.twig',array('user'=>$user,'messages'=>$pagination,'type'=>$type));
    }
    
    public function seeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $message = $em->getRepository("CoreDashboardBundle:Message")->find($id);
        return $this->render('CoreDashboardBundle:Message:see.html.twig',array('user'=>$user,'message'=>$message));

    }
    
    public function getBossDependence($service)
    {
        $em = $this->getDoctrine()->getManager();
        $groupManager = $this->get('fos_user.group_manager');
        $dependecy = $groupManager->findGroupByName($service);
        $getBoss = $em->createQuery("SELECT u FROM CoreUsersBundle:User u
                                     WHERE u.dependecyID = :dependecyID
                                     AND u.isBoss =1
                                     AND u.enabled = 1")
                     ->setParameter('dependecyID',$dependecy->getID())
                     ->getResult();
        if($getBoss)
        {
            $boss = $getBoss[0];
        }
        else
        {
            $boss = NULL;
        }
        
        return $boss;
    }
    
    
       public function getuserId($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $getUsers = $em->createQuery("SELECT u FROM CoreUsersBundle:User u
                                      WHERE u.id= :id")
                     ->setParameter('id',$id)
                     ->getResult();
        
        return $getUsers;
    }
    
    public function getusersService($dependecyID)
    {
        $em = $this->getDoctrine()->getManager();
        
        $getUsers = $em->createQuery("SELECT u FROM CoreUsersBundle:User u
                                      WHERE u.dependecyID = :dependecyID
                                      AND u.isBoss =0
                                      AND u.enabled = 1")
                     ->setParameter('dependecyID',$dependecyID)
                     ->getResult();
        
        return $getUsers;
    }
    
    public function historialAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $message = $em->getRepository("CoreDashboardBundle:Message")->find($id);
        
        $historial = $message->getHistorial();
        $paginator  = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate($historial, $request->query->getInt('page', 1),10);
   
        return $this->render('CoreDashboardBundle:Message:historial.html.twig',array('user'=>$user,'historials'=>$pagination));

    }

       public function historialSolAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$user = $this->container->get('security.context')->getToken()->getUser();
        $message = $em->getRepository("CoreDashboardBundle:Message")->find($id);
        
        $historial = $message->getHistorial();
        $paginator  = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate($historial, $request->query->getInt('page', 1),10);
   
        return $this->render('CoreDashboardBundle:Message:view.html.twig',array('historials'=>$pagination));

    }
    
    public function notifsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $notifs = $user->getNotifications();
        $items = array();
        foreach ($notifs as $notif)
        {
            if($notif->getIsViewed()== FALSE)
            {
                array_push($items, $notif);
            }
            $notif->setIsViewed(TRUE);
            $em->persist($notif);
            $em->flush();
        }
        $paginator  = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate($items, $request->query->getInt('page', 1),4);
   
        return $this->render('CoreDashboardBundle:Message:notifs.html.twig',array('user'=>$user,'notifs'=>$pagination));

    }
    
    public function petpdfAction(Request $request,$id)
    {
    
    $em = $this->getDoctrine()->getManager();
    $user = $this->container->get('security.context')->getToken()->getUser();
    $message = $em->getRepository("CoreDashboardBundle:Message")->find($id);
    $container = $this->container;
    
    
   $pdf = $this->peticionContent($message, $container); 
   $response = new Response();
   $response->setContent($pdf);
   $response->headers->set('Content-Type', 'application/force-download');
   $response->headers->set('Content-disposition', 'attachment=contracto.pdf');
   return $response;
    
   }
   
   
public function peticionContent($message,$container)
{
       
       $he=$this->container->get('templating.helper.assets')->getUrl('bundles/helpdesk/img/header.jpg');
       $fo=$this->container->get('templating.helper.assets')->getUrl('bundles/helpdesk/img/footer.jpg');
       //$prorroga=$em->getRepository('CoreContractsContractBundle:Prorroga')->findBy($id);
       
       $header="<img src='$he'>";      
       $footer="<img src='$fo'>";      
        $pdf = $container->get("white_october.tcpdf")->create();
        // set document information
        $pdf->SetCreator('OMAR HERNANDO FORERO GAMEZ');
        $pdf->SetAuthor('OMAR HERNANDO FORERO GAMEZ');
        $pdf->SetTitle('DETALLES DE PQRD');
        $pdf->SetSubject('DETALLES DE PQRD');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO_WIDTH, 'DETALLES DE PQRD', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-21, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE,0);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        $pdf->SetFont('helvetica', '', 10, '', true);

       // Add a page
        $pdf->SetPrintHeader(false);
       $pdf->AddPage();

       $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
       $username = $message->getCreatedBy()->getPrimerNombre()." ".$message->getCreatedBy()->getSegundoNombre()." ".$message->getCreatedBy()->getPrimerApellido()." ".$message->getCreatedBy()->getSegundoApellido();
       $tipodoc = $message->getCreatedBy()->getTipoDoc()->getDescripcion();
       $documento = $message->getCreatedBy()->getDocumento();
       $ubicacion = $message->getCreatedBy()->getCiudad()->getDescripcion();
       $direccion = $message->getCreatedBy()->getDireccion();
       $genero = $message->getCreatedBy()->getGenero()->getDescripcion();
       $telefono = $message->getCreatedBy()->getTelefono();
       $typo = $message->getDemandType()->getDemandType();
       //$code = $contract->getVerificationCode();
       $number = $message->getCode();
       $radicado= $message->getRadicado();
       if($message->getFecRa()){
       $fechar= $message->getFecRa()->format('d/m/Y');
       }else{
       $fechar="";
       }
       $area = $message->getCurrentService();
       $asunto = $message->getSubject();
       $object = $message->getMessage();
       //$valeur= $contract->getValue();
       $startDate = $message->getCreatedOn()->format('d/m/Y');
       /*if($message->getClosedOn()){
       $endDate = $message->getClosedOn()->format('d/m/Y');     
       }else{
       $endDate="";
       }*/
if($message->getAntesD()){
       $endDate = $message->getAntesD()->format('d/m/Y');     
       }else{
       $endDate="";
       }
// Set some content to print
        $html = <<<EOD
        <img src="$he">
<h2  align="center">DETALLES DE PQRD</h2>
<br><br>

<table>
<tr><td width="180">Tipo Documento:</td><td>$tipodoc</td></tr>
<tr><td>Documento:</td><td>$documento</td></tr>
<tr><td>Solicitante :</td><td>$username</td></tr>
<tr><td>Ubicacion Geografica:</td><td>$ubicacion</td></tr>
<tr><td>Direccion:</td><td>$direccion</td></tr>
<tr><td>Genero:</td><td>$genero</td></tr>
<tr><td>Telefono:</td><td>$telefono</td></tr>
</table>
<br><br>
<table>
<tr><td width="180">Número de Ticket:</td><td>$number
</td></tr>
<tr><td>Número de Radicado:</td><td>$radicado
</td></tr>
<tr><td>Fecha de Radicacion:</td><td>$fechar
</td></tr>
<tr><td>Area Actual : </td><td>$area</td></tr>
<tr><td>Tipo Peticion : </td><td>$typo</td></tr>
<tr><td>Fecha Creacion : </td><td>$startDate</td></tr>
<tr><td><b>Debe Responderse antes de :</b></td><td><b>$endDate</b></td></tr>
<tr><td>Asunto :</td><td>$asunto</td></tr>
<tr><td>Objeto :</td><td>$object</td></tr>
</table>

<br><br>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div id="footer" style="bottom:0!important;">
<img src="$fo" align="top">
</div>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output('DETALLES DE PQRD.pdf', 'I');
        
        return $pdf;
    }
    
    
 public function csvAction(Request $request,$id){
   
    $user = $this->container->get('security.context')->getToken()->getUser();
    $form = $this->createFormBuilder()
        ->add('submitFile', 'file', array('label' => 'Subir Archivo'))
        ->getForm();
    $v="2016";
    $ei="E";
    $er="E";
    $c="216";
    $t="O";    

// Check if we are posting stuff
if ($request->getMethod('post') == 'POST') {
    // Bind request to the form
    $form->handleRequest($request);

    // If form is valid
    if ($form->isValid()) {
        
         $em = $this->getDoctrine()->getManager();
         /** @var Symfony\Component\HttpFoundation\File\UploadedFile $files */
         $files = $form->get('submitFile');
          
         $fileName = md5(uniqid()).'.'.$files->getData()->guessExtension();
         
         $fileDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/temp';
         
         $files->getData()->move($fileDir, $fileName);
         
         
         $file = new \SplFileObject($fileDir.'/'.$fileName);
         $reader = new CsvReader($file, ';');
          //new ExcelReader($file);
         
         $reader->setHeaderRowNumber(0);
         $entity =$em->getRepository("CoreDashboardBundle:Message")->find($id);
        foreach ($reader as $row) {
        
              $radicado=$row['VIGENCIA'].$row['EXTERNA_INTERNA'].$row['ENVIADA_RECIBIDA'].$row['CODIGO_DOCUMENTO']."  ".$row['TIPO'];
                                         
              $entity->setRadicado($radicado);
              //$entity->setCreatedOn(new \DateTime($row['hasta']));
              $antes=date("Y-m-d", strtotime($row['FECHA_LIMITE']));
              $fecra=date("Y-m-d", strtotime($row['FECHA_RADICADO']));
              $entity->setAntesD(new \DateTime($antes));
              $entity->setFecRa(new \DateTime($fecra));
              $em->persist($entity);
            
                  }                                   
                  $em->flush(); 
                  $em->clear();
                  $this->addFlash('success', 'El archivo se cargo correctamente!');                                    
                  
return $this->render('CoreDashboardBundle:Message:csv.html.twig',
    array('form' => $form->createView(),'user'=>$user)
);
   
    }

 }

return $this->render('CoreDashboardBundle:Message:csv.html.twig',
    array('form' => $form->createView(),'user'=>$user)
);
          
  }


 private function createSolicitanteForm(Solicitante $entity){
        $form = $this->createForm(new SolicitanteType(), $entity, array(
            'action' => $this->generateUrl('solicitante_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear','attr'=>array('class'=>'btn btn-success','style'=>'margin-top:11px')));
        return $form;
    }


public function newSolicitanteAction(){

        $entity = new Solicitante();
        $form   = $this->createSolicitanteForm($entity);

        return $this->render('CoreDashboardBundle:Solicitante:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }

public function correoSolicitanteAction(Request $request){


        $id = $_POST['correo'];
//$id="elgranjm4000@gmail.com";
	 $em = $this->getDoctrine()->getManager();
	 $queryc = $em->createQuery(
        "SELECT p
        FROM CoreDashboardBundle:Solicitante p
        WHERE p.correo = '$id'
        "
        );
        $datos = $queryc->getResult();

	 $generardatos = false;
        if(count($datos)>0){
            $generardatos = true;
        }
        return new JsonResponse($generardatos);

    }



    /**
     * Displays a form to create a new CorpoTicket entity.
     *
     */
    public function createSolicitanteAction(Request $request)
    {
        $entity = new Solicitante();
        $form = $this->createSolicitanteForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $solicitante = $em->getRepository('CoreDashboardBundle:Solicitante')->findOneBy(array('documento'=>$form->get('documento')->getData()));
            if(!is_null($solicitante)){
                $this->addFlash('danger', 'Este numero de documento ya existe!');
                return $this->render('CoreDashboardBundle:Solicitante:new.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ));
            }else {



        //SEND EMAIL TO THE EXTERNAL
        $message = "envio de correo";
                $mail = \Swift_Message::newInstance()
                        ->setSubject("Your request has been treated and closed ")
                        ->setFrom('safwen.bensalem@mapp-net.com')
                        ->setTo("elgranjm3000@gmail.com")
                        ->setContentType("text/html")
                        ->setBody('CoreDashboardBundle:Message:mail.html.twig',array('message'=>$message))
                        ;
               $this->get('mailer')->send($mail);
        







		$email   = $form["correo"]->getData();
	        $asunto  = "Consulta";
        	$mensaje = "Codigo por correo";
	        mail($email, $asunto, $mensaje);
                $entity->setTerminos(1);
                $p = $em->getRepository('CoreDashboardBundle:Poblacion')->findOneBy(array('id'=>1));
                $entity->setPoblacion($p);
                $em->persist($entity);
                $em->flush();
                $this->addFlash('success', 'Solicitante agregado correctamente ahora puede crear su solicitud!');
                return $this->redirect($this->generateUrl('write_message'));
            }
        }

        return $this->render('CoreDashboardBundle:Solicitante:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }

    /**
     * Displays a form to create a new CorpoTicket entity.
     *
     */
    public function inicioAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('my_messages'))
            ->setMethod('POST')
            ->add('documento', 'text', array('label' => 'Digite n° documento','attr'=>array('class'=>'form-control')))
            ->getForm();
        $form->add('submit', 'submit', array('label' => 'Buscar','attr'=>array('class'=>'btn btn-success','style'=>'margin-top:11px')));

        $entities = new Message();

        return $this->render('CoreDashboardBundle:Solicitante:inicio.html.twig',
            array('form' => $form->createView(),
                'entities'=>$entities,
            )
        );

    }


    public function documentoAction(Request $request){

            $documento = $_POST['term'];
            $em = $this->getDoctrine()->getManager();

	$queryc = $em->createQuery(
        "SELECT p
        FROM CoreDashboardBundle:Solicitante p
        WHERE p.documento = $documento"
        );
        $result = $queryc->getResult();

$generardatos = false;
if(count($result)>0){
	$generardatos = true;
}

 return new JsonResponse($generardatos);

    }


    public function listadoAction(Request $request){

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('solicitante_listado'))
            ->setMethod('POST')
            ->add('documento', 'text', array('label' => 'Documento'))
            ->getForm();
        $form->add('submit', 'submit', array('label' => 'Buscar'));

        $entities = new Solicitante();

// Check if we are posting stuff
        if ($request->getMethod('post') == 'POST') {

            // Bind request to the form
            $form->handleRequest($request);
            // If form is valid
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $solicitante = $em->getRepository('CoreDashboardBundle:Solicitante')->findOneBy(array('documento'=>$form->get('documento')->getData()));
                if(is_null($solicitante)){
                    $this->addFlash('danger', 'Este numero de documento no existe!');
                    return $this->render('CoreDashboardBundle:Solicitante:inicio.html.twig', array(
                        'entities' => $entities,
                        'form'   => $form->createView(),
                    ));
                }
                $entities = $em->getRepository('CoreDashboardBundle:Solicitante')->findBy(array('uid' => $solicitante->getId()), array('creado' => 'ASC'));
                return $this->render('CoreDashboardBundle:Solicitante:index.html.twig',
                    array('entities' => $entities,)
                );
            }
            return $this->render('CoreDashboardBundle:Solicitante:inicio.html.twig', array(
                'entities' => $entities,
                'form'   => $form->createView(),
            ));
        }

        return $this->render('CoreDashboardBundle:Solicitante:index.html.twig', array(
            'entities' => $entities,
            'form'   => $form->createView(),
        ));
    }
    
    
     public function ciudadAction(Request $request) {
        $request = $this->getRequest();

        $q = $request->get('q');
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $result = $qb->select('c')->from('CoreDashboardBundle:Ciudades', 'c')
                ->where($qb->expr()->eq('c.dep','?1'))
                ->setParameter(1,$q)
                ->getQuery()
                ->getArrayResult();

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    
     public function peticionesAction(Request $request)
{

  /*$form = $this->createFormBuilder()
            ->add('fecha1','text', array('label' => 'Fecha Inicial ','attr'=>array('class'=>'fecha')
                ))
            ->add('fecha2', 'text', array('label' => 'Fecha Final ','attr'=>array('class'=>'fecha')
            ))
            ->getForm();
// Check if we are posting stuff
        if ($request->getMethod('post') == 'POST') {
            // Bind request to the form
            $form->handleRequest($request);

            // If form is valid
            if ($form->isValid()) {
                $fecha1= $form->get('fecha1')->getData();
                $fecha2= $form->get('fecha2')->getData();
     */
$em = $this->getDoctrine()->getManager();

$sql="SELECT
solicitante.primer_nombre,
solicitante.segundo_nombre,
solicitante.primer_apellido,
solicitante.segundo_apellido,
message.`code`,
message.radicado,
message.fec_ra,
message.currentService,
message.`subject`,
demand.demandType,
message.createdOn,
message.closedOn,
message.`status`
FROM
message
INNER JOIN solicitante ON message.createdBy = solicitante.id
INNER JOIN demand ON message.demandType = demand.demandID";

$statement = $em->getConnection()->prepare($sql);
$statement->execute();
$results= $statement->fetchAll();
    
   $objPHPExcel = new PHPExcel();

                    $objPHPExcel->getProperties()->setCreator("Corpochivor")
                        ->setLastModifiedBy("Corpochivor")
                        ->setTitle("Peticiones")
                        ->setSubject("Office 2007 XLSX Test Document")
                        ->setDescription("Peticiones")
                        ->setKeywords("office 2007 openxml php")
                        ->setCategory("Peticiones");


                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2:M2')->getFont()->setBold(true);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:M1')->getFont()->setBold(true);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:M3')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);    
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);                    
                    
                    $style = array(
                        'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            //'top'=>\PHPExcel_Style_Alignment::VERTICAL_TOP,
                        )
                    );
                                                                                                    
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:M1')->applyFromArray($style);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2:M2')->applyFromArray($style);
                    //$objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:O3')->applyFromArray($style);


                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:M1')->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2:M2')->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setWrapText(true); 


                   $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:M1')->setCellValue('A1','Peticiones Recibidas');

                   $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:M2')->setCellValue('A2','Detalles de Peticiones');

                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3','Primer Nombre');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3','Segundo Nombre');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3','Primer Apellido');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3','Segundo Apellido');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3','No. de Ticket');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3','No. de Radicado');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3','Fecha de Radicacion');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3','Dependencia');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3','Asunto');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3','Tipo Denuncia'); 
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3','Fecha de Creacion ');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3','Fecha de Cierre');
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3','Estado');
                   
                   $objPHPExcel->getActiveSheet()->fromArray($results, null, 'A4');

                   //$objPHPExcel->getActiveSheet()->fromArray($results, null, 'A4');                  

                    $objPHPExcel->getActiveSheet()->setTitle('Listado de Peticiones Recibidas');

                    $objPHPExcel->setActiveSheetIndex(0);          

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Peticiones.xlsx"');
                header('Cache-Control: max-age=0');
                header('Cache-Control: max-age=1');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');
                exit;

                $response = new BinaryFileResponse($objWriter);
                return $response;
                /* }
                }
                return $this->render('IndicadorBundle:Evaluacion:excel.html.twig', array(
                    'form' => $form->createView(),
                 )); */
    
}

    
    
}
