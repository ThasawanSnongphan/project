
import java.net.*;
import java.io.*;

public class GetWeb {

    public static void main(String[] args) {
        if (args.length != 2) {
            System.exit(0);
        } else {
            try {
                File f = new File("C:\\Users\\p\\Desktop\\network_programming\\lab7\\src\\getweb.html");
                Socket s = new Socket(args[0], 80);
                InputStream in = s.getInputStream();
                OutputStream out = s.getOutputStream();

                BufferedReader sin = new BufferedReader(new InputStreamReader(in));
                PrintWriter sout = new PrintWriter(out, true);
                FileOutputStream fout = new FileOutputStream(f);
                PrintWriter pout = new PrintWriter(fout,true);
                
                /////////APT///////////
                sout.println("GET " + args[1] + " HTTP/1.1");
                sout.println("Host: " + args[0]);
                sout.println("Connection: close");
                sout.println("");
                sout.println("");

                String a;
                while ((a = sin.readLine()) != null) {
                   pout.println(a);
                   
                }
                fout.close();
                pout.close();
                sin.close();
                sout.close();

            } catch (Exception e) {
                e.printStackTrace();
            }
        }
    }
}
