import java.net.*;
import java.io.*;
import java.util.concurrent.*;
import java.util.*;
        
public class Server extends Thread {
    private static final HashMap<String, String> map = new HashMap<>();
    Socket s = null;
    
    public Server(Socket s) {
        this.s = s;
    }

    public void run() {
        try {
            BufferedReader br = new BufferedReader(new InputStreamReader(s.getInputStream()));
            PrintWriter pw = new PrintWriter(s.getOutputStream(), true);
            
            String cmd = br.readLine(); //recive from Client
//            String studentID = br.readLine();
//            String studentName = br.readLine();
            
            if(cmd.equals("add")){
                String studentID = br.readLine();
                String studentName = br.readLine();
                map.put(studentID,studentName);
                pw.println("OK");
            }else if(cmd.equals("search")){
                String studentID = br.readLine();
                String studentName = map.get(studentID);
                if(studentName != null){
                    pw.println("Student name: " + studentName);
                }else {
                    pw.println("N/A");
                }
            }else{
                pw.println("Command not found");
            }
            
            
            
            br.close();
            pw.close();
            s.close();
        } catch (Exception e) { e.printStackTrace();}

    }

    public static void main(String args[]) {
        ServerSocket servSocket = null;
        ExecutorService es = Executors.newFixedThreadPool(10);
        try {
            servSocket = new ServerSocket(23410);
        } catch (Exception e) {
            System.exit(1);
        }

        while (true) {
            try {
                Socket s = servSocket.accept();
                Server t = new Server(s);
                es.execute(t);
            } catch (Exception e) { e.printStackTrace();}
        }
    }
}
