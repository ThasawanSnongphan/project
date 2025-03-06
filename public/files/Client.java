import java.net.*;
import java.io.*;
import java.net.Socket;


public class Client {
    public static void main(String[] args) {
        
        String cmd = args[0];
        String studentID = args[1];
        String studentName = null;
        if(args.length > 2 ){
            studentName = args[2];
        }else{
            studentName = "";
        }
         
        try {
            Socket s = new Socket("127.0.0.1", 23410);
            BufferedReader br = new BufferedReader(new InputStreamReader(s.getInputStream()));
            PrintWriter pw = new PrintWriter(s.getOutputStream(),true);
            
            pw.println(cmd);
            
            if(cmd.equals("add")){
                pw.println(studentID);
                pw.println(studentName);
            }
            
            else if(cmd.equals("search")){
                pw.println(studentID);
            }
            
            else {
                if(!cmd.equals("add") || !cmd.equals("search"))
                    System.out.println("Command not found");
            }
            String msg = br.readLine();
               System.out.println(msg);
            br.close();
            pw.close();
            s.close();
        } catch (Exception e) {}
    }
}
