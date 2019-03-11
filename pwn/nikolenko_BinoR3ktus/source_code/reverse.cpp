#include <iostream>
#include <cstring>
#include <cstdlib>

void motd() {
	printf(R"(
		   #                              #     #                      
		  # #   #####  #    # # #    #    ##   ## ###### #    # #    # 
		 #   #  #    # ##  ## # ##   #    # # # # #      ##   # #    # 
		#     # #    # # ## # # # #  #    #  #  # #####  # #  # #    # 
		####### #    # #    # # #  # #    #     # #      #  # # #    # 
		#     # #    # #    # # #   ##    #     # #      #   ## #    # 
		#     # #####  #    # # #    #    #     # ###### #    #  ####  
	)");
}

int main()
{
	//char flag[] = { '\x43', '\x54', '\x46', '\x7b', '\x72', '\x45', '\x76', '\x65', '\x52', '\x73', '\x57', '\x61', '\x53', '\x4f', '\x57', '\x6e', '\x65', '\x64', '\x7d' };
	char flag[] = { '\x43', '\x54', '\x46', '\x7b', '\x75', '\x48', '\x79', '\x68', '\x55', '\x76', '\x5a', '\x64', '\x56', '\x52', '\x5a', '\x71', '\x68', '\x67', '\x7d' };
	char pass[32];
	bool access = false;
	while (!access)
	{
		printf("\033[34m"); motd(); printf("\033[36m");
		printf("\nInput password:\033[39m "); scanf("%s", &pass);
		if(!strcmp(pass, "[0x3:4]=0x1010243")) {
			access = true;
			system("clear");
			printf("\033[34m"); motd();
			printf("\n\t\t\t\t\033[32mAccess granted!\n\t\t\t     ");
			for (int i = 0; i <= 18; i++) {
				if (i > 3 && i < 18) 
					printf("%c", flag[i] - 3);

				else printf("\033[33m%c", flag[i]);
			}
			printf("\n");
		}
		else 
		{
			system("clear");
			printf("\t\t\t\t\033[31mERROR! Wrong password! Try again...\033[30m\n\n");	
		}
	}

	return 0;
}
